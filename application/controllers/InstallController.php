<?php

class InstallController extends MX_Controller
{

    public $module;
    private $moduleData;

    protected $provider;
    protected $messages = array();


    public function start()
    {
        $this->load->view('helpers/master', array(
            'view' => 'helpers/install/start'
        ));
    }


    public function install($module)
    {
        /**
         * Modules::find() indisli array olarak ['path', 'file'] şeklinde değer döndürür.
         * İlk değer (path) dosya bulunamaması durumunda false döner.
         */
        $insrallerFile = Modules::find('Installer.php', ucfirst($module), 'installer/');

        if ($insrallerFile[0] === false) {
            throw new Exception('Kurulum (installer) dosyasi bulunamadi.');
        }

        $insrallerFile = implode('', $insrallerFile);

        require_once $insrallerFile;

        $this->module = $module;
        $this->provider = new Installer();

        if (! $this->isInstalled()) {

            /**
             * Modules::find() indisli array olarak ['path', 'file'] şeklinde değer döndürür.
             * İlk değer (path) dosya bulunamaması durumunda false döner.
             */
            $sqlFile = Modules::find('Database.sql', ucfirst($module), 'installer/');
            $sqlString = '';

            if ($sqlFile[0] !== false) {
                $sqlString = $this->load->file(implode('', $sqlFile), true);
            }

            if ($sqlString) {
                $queries = explode(';', $sqlString);

                foreach($queries as $query) {
                    $query = trim($query);

                    if (! empty($query)) {
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                        $this->db->query($query);
                        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
                    }
                }
            }

            $this->saveModule();
            $this->callMethods();
            $this->addRoutes();
            $this->addReservedUri();
        };

        $this->load->view('helpers/master', array(
            'view' => 'helpers/install/install',
            'data' => array(
                'messages' => $this->messages
            )
        ));
    }


    private function isInstalled()
    {
        if (! $this->db->table_exists('modules')) {
            return false;
        }

        $module = $this->getModule();

        if ($module) {
            $this->messages[] = 'Modül kurulumu yapılmış.';

            if (isset($this->provider->tables)) {

                $missing = array();

                foreach ($this->provider->tables as $table) {
                    if (! $this->db->table_exists($table)) {
                        $missing[] = $table;
                    }
                }

                if (count($missing) > 0) {
                    $this->messages[] = 'Modül kurulumu hatalı!';
                    $this->messages[] = 'Eksik tablolar mevcut:';
                    $this->messages[] = implode('<br>', $missing);
                }
            }

            return true;
        }

        return false;
    }


    private function saveModule()
    {
        $this->db->insert('modules', array(
            'title' => '',
            'name' => $this->module,
            'modified' => 0,
            'permissions' => '',
            'type' =>  null,
            'icon' =>  null,
            'menuPattern' => null,
            'controller' => '',
        ));

        $this->messages[] = 'Modül kuruldu.';
    }


    private function getModule()
    {
        if (empty($this->moduleData)) {
            $this->moduleData = $this->db
                ->from('modules')
                ->where('name', $this->module)
                ->get()
                ->row();
        }

        return $this->moduleData;
    }


    private function callMethods()
    {
        $methods = array();

        if (! empty($this->provider->steps)) {
            foreach ($this->provider->steps as $step) {
                if (method_exists($this->provider, $step)) {
                    $methods[] = $step;
                }
            }
        } else {
            foreach (get_class_methods($this->provider) as $step) {
                if (strpos($step, '__') === false) {
                    $methods[] = $step;
                }
            }
        }

        foreach ($methods as $method) {
            $this->provider->$method();
        }

    }


    private function addRoutes()
    {
        if (empty($this->provider->routes)) {
            return false;
        }

        $languages = $this->config->item('languages');

        foreach ($languages as $language => $label) {
            if (isset($this->provider->routes[$language]['route'])) {

                $filepath = APPPATH . 'config/routes.php';
                $file = fopen($filepath, FOPEN_WRITE_CREATE);
                $data = '';

                foreach ($this->provider->routes[$language]['route'] as $pattern => $action) {
                    $patterns = array();

                    // Aktif dil tr değilse prefix ekle.
                    if ($language !== 'tr') {
                        $patterns[] = $language;
                    }

                    // Aktif pattern'de @uri parametresi varsa uri değerini replace et.
                    if (isset($this->provider->routes[$language]['uri'])) {
                        $pattern = str_replace("@uri", $this->provider->routes[$language]['uri'], $pattern);
                    }

                    if (! empty($pattern)) {
                        $patterns[] = $pattern;
                    }

                    if (count($patterns) > 0) {
                        $data .= '$route[\''. implode('/', $patterns) .'\'] = \''. $action .'\';'. PHP_EOL;
                    }
                }

                flock($file, LOCK_EX);
                fwrite($file, $data);
                flock($file, LOCK_UN);
                fclose($file);

                $this->messages[] = 'Rotasyon yapıldı. ('. $label .')';
            }
        }
    }


    private function addReservedUri()
    {
        if (empty($this->provider->routes)) {
            return false;
        }

        $languages = $this->config->item('languages');

        foreach ($languages as $language => $label) {
            if (isset($this->provider->routes[$language]['uri'])) {

                $filepath = APPPATH . 'config/reservedUri.php';
                $file = fopen($filepath, FOPEN_WRITE_CREATE);
                $data = '$config[\'reservedUri\'][\''. $language .'\'][\'@'. $this->module .'\'] = \''. $this->provider->routes[$language]['uri'] .'\';'. PHP_EOL;

                flock($file, LOCK_EX);
                fwrite($file, $data);
                flock($file, LOCK_UN);
                fclose($file);


                $this->messages[] = 'Rezerve url eklendi. ('. $label .')';
            }
        }
    }


} 