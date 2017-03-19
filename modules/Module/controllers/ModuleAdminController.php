<?php

use Controllers\AdminController;

class ModuleAdminController extends AdminController
{
    private $repositoryPath = './vendor/sirius-ci';
    private $backupPath = './backup';
    private $modulePath = './modules';
    private $ignoreFiles = array(
        '.git',
        '.gitignore',
        'README.md'
    );

    public $moduleTitle = 'Modüller';
    public $module = 'module';
    public $model = 'module';

    public $actions = array(
        'records' => 'list',
        'update' => 'update',
        'delete' => 'delete',
        'order' => 'order',
        'repository' => 'root',
        'init' => 'root',
    );

    /**
     * Modül listeleme.
     *
     * @success
     */
    public function records()
    {
        parent::callRecords();
        $this->render('records');
    }

    /**
     * Modül ayarları güncelleme.
     *
     * @success
     */
    public function update()
    {
        if (!$record = $this->appmodel->name($this->uri->segment(4))) {
            show_404();
        }

        $rules = array();

        if ($this->input->post()) {
            foreach ($record->arguments as $argument) {
                if (!empty($argument->arguments)) {
                    $rules[$argument->name] = array(implode('|', array_keys($argument->arguments)), "Lütfen {$argument->title} geçerli bir değer veriniz.");
                }
            }

            $this->validate($rules);

            if (!$this->alert->has('error')) {
                $success = $this->appmodel->update($record);

                if ($success) {
                    $this->alert->set('success', 'Kayıt düzenlendi.');
                    $this->makeRedirect(['update', $record->name]);
                }

                $this->alert->set('warning', 'Kayıt düzenlenmedi.');
            }
        }

        $this->assets->importEditor();
        $this->utils->breadcrumb("{$record->title}: Düzenle");

        $this->viewData['record'] = $record;

        $this->render('update');
    }

    /**
     * Modül silme.
     *
     * @success
     */
    public function delete()
    {
        parent::callDelete();
    }

    /**
     * Modül sıralama.
     *
     * @success
     */
    public function order()
    {
        parent::callOrder();
    }

    /**
     * Yüklenebilir modüller.
     *
     * @success
     */
    public function repository()
    {
        $detectRepositoryModules = $this->detectModules($this->repositoryPath);
        $detectCopiedModules = $this->detectModules($this->modulePath);
        $modules = $this->appmodel->all();

        // Kurulmuş modül kontrolü.
        foreach ($modules as $module) {
            if (isset($detectRepositoryModules[$module->name])) {
                $detectRepositoryModules[$module->name]->installed = true;
            }

            if (isset($detectCopiedModules[$module->name])) {
                $detectCopiedModules[$module->name]->installed = true;
            }
        }

        // Kopyalanmış modül kontrolü.
        foreach ($detectCopiedModules as $module) {
            if (isset($detectRepositoryModules[$module->name])) {
                $detectRepositoryModules[$module->name]->copied = true;
            }
        }

        $this->utils->breadcrumb('Yüklenebilir Modüller');

        $this->viewData['repositoryModules'] = $detectRepositoryModules;
        $this->viewData['copiedModules'] = $detectCopiedModules;

        $this->render('repository');
    }

    /**
     * Modül dosyalarının yüklenmesi.
     *
     * @success
     */
    public function init()
    {
        $module = $this->uri->segment(4);
        $detectModules = $this->detectModules($this->repositoryPath);

        if (! isset($detectModules[$module])) {
            $this->alert->set('error', 'Modül repository bulunamadı.');
            redirect($this->input->server('HTTP_REFERER'));
        }

        // Yedek dizini modüle ismine göre timestamp eklenerek oluşturulur.
        $backupPath = $this->backupPath .'/'. ucfirst($module) .'/'. time();

        // Yedek dizini yok ise oluşturulur.
        if (! is_dir($this->backupPath)) {
            mkdir($this->backupPath);
            chmod($this->backupPath, 0777);
        }

        // Kopyalanmayacak dosya ve dizinlerin tam yolu tanımlanır.
        foreach ($this->ignoreFiles as &$file) {
            $file = $detectModules[$module]->path . '/' . $file;
        }

        /**
         * Kopyalama işlemi yapılır.
         *
         * İlk: Modülün vendor yolu.
         * İkinci: Modülün hedef yolu yolu.
         * Üçüncü: Modülün yedek yolu yolu.
         * Dördüncü: Kopyalanmayacak dosyalar.
         */
        $this->copyFiles($detectModules[$module]->path, $this->modulePath .'/'. ucfirst($module), $backupPath, $this->ignoreFiles);

        @rmdir($backupPath);

        $this->alert->set('success', 'Modül başarıyla kopyalandı.');
        redirect($this->input->server('HTTP_REFERER'));
    }

    /**
     * Oluşturulan modül kaynaklarını saptar.
     *
     * @params string $path Modüllerin saptanacağı dizin.
     * @throws \Exception
     * @success
     */
    private function detectModules($path)
    {
        $modules = array();

        // Module dizin kontrolü yapılır.
        if (! file_exists($path)) {
            $this->alert->set('error', 'Repository dizini bulunamadı.');

            return $modules;
        }

        $moduleIterator = new \DirectoryIterator($path);

        foreach ($moduleIterator as $iteratorFile) {
            // Dizin elemanlarının klasör olup olmadığı kontrol edilir.
            if ($iteratorFile->isDir() && !$iteratorFile->isDot()) {

                // Dizin ismini döndürür.
                $moduleName = strtolower($iteratorFile->getFilename());
                $modulePath = $iteratorFile->getPathname();

                $modules[$moduleName] = (object) array(
                    'name' => $moduleName,
                    'path' => $modulePath,
                    'installed' => false,
                    'copied' => false
                );
            }
        }

        return $modules;
    }

    /**
     * Dosya kopyalama
     *
     * @param string $source Kopyalanacak kaynağın dizin yolu.
     * @param string $target Kopyalanacak yerin dizin yolu.
     * @param bool|false|string $backup Yedek alınacaksa yedek dizin yolu.
     * @param array $ignoreFiles Kopyalanmayacak dosya ve dizinler.
     * @return bool
     * @success
     */
    private function copyFiles($source, $target, $backup = false, $ignoreFiles = array())
    {
        foreach ($ignoreFiles as $file) {
            if (strpos($source, $file) !== false) {
                return false;
            }
        }

        // Kaynak dosya ise yedekleme ve kopyapama işlemini yap.
        if (is_file($source)) {
            if (is_file($target) && $backup !== false) {
                copy($target, $backup);
            }

            return copy($source, $target);
        }

        // Kaynak dizinse ve hedef dizinse, hedef dizinin yedeklenmesi gerekmekte, yedekle.
        if (is_dir($source) && is_dir($target) && $backup !== false) {
            mkdir($backup, 0777, true);
        }

        // Hedef dizin yoksa hedef dizini oluştur. Üstte dizinse yedekle işlemi yapılmıştı.
        if (! is_dir($target)) {
            mkdir($target, 0777, true);
        }

        $sourceIterator = new \DirectoryIterator($source);

        foreach ($sourceIterator as $iteratorFile) {
            // Dizin elemanlarının klasör olup olmadığı kontrol edilir.
            if (!$iteratorFile->isDot()) {
                $dirName = $iteratorFile->getFilename();
                $backupPath = false;

                if ($target !== "$source/$dirName") {
                    if ($backup !== false) {
                        $backupPath = "$backup/$dirName";
                    }

                    $this->copyFiles("$source/$dirName", "$target/$dirName", $backupPath, $ignoreFiles);
                }
            }
        }

        return true;
    }


}