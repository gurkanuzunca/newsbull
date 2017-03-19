<?php



class Alert
{
    /**
     * @var object
     */
    private $session;

    private $sessionKey = 'sirius.alerts';
    private $alerts = array();

    /**
     * Alert constructor.
     * CI session objesini tanımlar.
     * Sessionda bulunan uyarıları tanımlar.
     */
    public function __construct()
    {
        $this->session =& get_instance()->session;
        $this->alerts = $this->session->userdata($this->sessionKey);

        if (! is_array($this->alerts)) {
            $this->alerts = array();
        }
    }

    /**
     * Uyarıyı html olarak döndürür ve uyarıyı temizler.
     *
     * @param array|string $types
     * @param string $suffix
     * @return bool|string
     */
    function flash($types, $suffix = 'default')
    {
        if (! is_array($types)) {
            $types = array($types);
        }

        foreach ($types as $type) {
            $alerts = $this->get($type, $suffix);

            if ($alerts) {
                $response = '';
                $this->clear($type, $suffix);

                foreach ($alerts as $alert) {
                    $response .= '<p>'. $alert .'</p>';
                }

                return '<div class="alert alert-'. $type .'">'. $response .'</div>';
            }
        }

        return false;
    }

    /**
     * Uyarının varlığını komtrol eder.
     *
     * @param null $type
     * @param string $suffix
     * @return bool
     */
    public function has($type = null, $suffix = 'default')
    {
        if ($type !== null) {
            return isset($this->alerts[$suffix][$type]);
        }

        return isset($this->alerts[$suffix]);
    }

    /**
     * Yeni uyarı tanımlar.
     *
     * @param string $type
     * @param array|string $message
     * @param string $suffix
     */
    public function set($type, $message, $suffix = 'default')
    {
        if (! $this->has($type, $suffix)) {
            $this->alerts[$suffix][$type] = array();
        }

        if (is_array($message)) {
            $this->alerts[$suffix][$type] = array_merge($this->alerts[$suffix][$type], $message);
        } else {
            $this->alerts[$suffix][$type][] = $message;
        }

        $this->refresh();
    }

    /**
     * Uyarıyı döndürür.
     *
     * @param null $type
     * @param string $suffix
     * @return array|bool
     */
    public function get($type = null, $suffix = 'default')
    {
        if ($type !== null) {
            if (isset($this->alerts[$suffix][$type])) {
                return $this->alerts[$suffix][$type];
            }
        } else {
            if (isset($this->alerts[$suffix])) {
                return $this->alerts[$suffix];
            }
        }

        return false;
    }

    /**
     * Uyarıyı temizler.
     *
     * @param null $type
     * @param string $suffix
     */
    public function clear($type = null, $suffix = 'default')
    {
        if ($type !== null) {
            unset($this->alerts[$suffix][$type]);
        } else {
            unset($this->alerts[$suffix]);
        }

        $this->refresh();
    }

    /**
     * Uyarıları sessionda günceller.
     */
    private function refresh()
    {
        $this->session->set_userdata($this->sessionKey, $this->alerts);
    }


}
