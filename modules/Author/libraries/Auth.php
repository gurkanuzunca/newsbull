<?php


class Auth
{
    private $ci;
    private $logged = false;
    private $user;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('user/user');
        $this->ci->load->helper('user/user');
        $this->ci->load->helper('cookie');

        $this->check();
    }

    /**
     * Kriterlere göre kullanıcı sorgusu yapar.
     *
     * @param array $criteria
     * @param bool|true $remember
     * @return bool
     */
    public function attempt(array $criteria, $remember = true)
    {
        $user = $this->ci->user->findByCriteria($criteria);

        if (! $user) {
            return false;
        }

        if ($remember === true) {
            $this->ci->user->createRememberToken($user);
            set_cookie('rememberToken', $user->rememberToken, 2592000, $this->ci->input->server('HTTP_HOST'));
            // 30 günlük cookie
        }

        $this->init($user);

        return true;
    }

    /**
     * Logged set edildiyse işlem gerçekleştirmez,
     * Session oluşturulmuşsa userId'e göre kontrol eder,
     * Çerez atılmışsa rememberToken'a göre kontrol eder
     * Doğrulama yapıldığında true döner.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->logged()) {
            return true;
        }

        $authUserId = (int) $this->ci->session->userdata('authUserId');

        if ($authUserId !== 0) {
            return $this->attempt(['id' => $authUserId], false);
        }

        $rememberToken = get_cookie('rememberToken');

        if (strlen($rememberToken) == 32) {
            return $this->attempt(['rememberToken' => $rememberToken], false);
        }

        return false;
    }


    /**
     * Geçerli kullanıcı bulunduysa oturum için gerekli tanımlamalar yapılır.
     *
     * @param $user
     */
    private function init($user)
    {
        $this->user = $user;
        $this->logged = true;
        $this->ci->session->set_userdata('authUserId', $user->id);
    }


    /**
     * Oturumu açılmış olan kullanıcı bilgisini döndürür.
     *
     * @return mixed
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Oturum kontrolü.
     *
     * @return bool
     */
    public function logged()
    {
        return $this->logged;
    }

    /**
     * Oturum kapat
     *
     * @return void
     */
    public function logout()
    {
        $this->ci->session->set_userdata('authUserId', null);
        $this->ci->session->unset_userdata('authUserId');
        set_cookie('rememberToken', '', -3600, $this->ci->input->server('HTTP_HOST'));
    }


}