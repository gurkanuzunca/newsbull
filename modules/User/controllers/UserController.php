<?php

use Controllers\BaseController;

class UserController extends BaseController
{
    public $module = 'user';

    /**
     * Üyelere özel sayfalar.
     * @var array
     */
    private $loggedActions = array('index', 'profile', 'password', 'avatar', 'notification');

    /**
     * Ziyaretçiye özel sayfalar.
     * @var array
     */
    private $guestActions = array('login', 'create');


    public function index()
    {
        $this->middleware();
        $this->render('user/index', array());
    }


    public function login()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->validate([
                'email' => array('required', ''),
                'password' => array('required', '')
            ]);

            if (! $this->alert->has('error')) {
                $logged = $this->auth->attempt([
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password')
                ]);

                if ($logged === true) {
                    redirect(clink(['@user']));
                }
            } else {
                $this->alert->clear('error');
                $this->alert->set('error', 'Giriş bilgileri hatalı.');

                redirect(clink(['@user', 'giris']));
            }
        }

        $this->render('user/login', array());
    }



    public function logout()
    {
        $this->auth->logout();
        redirect(clink(['@home']));
    }


    public function create()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->validate([
                'email' => array('required|valid_email', 'Lütfen geçerli bir e-mail adresi yazınız.'),
                'password' => array('required|min_length[6]', 'Lütfen geçerli bir parola yazınız.'),
                'name' => array('required', 'Lütfen adınızı yazınız.'),
                'surname' => array('required', 'Lütfen soyadınızı yazınız.')
            ]);

            if (! $this->alert->has('error')) {
                if ($this->user->exists($this->input->post('email'))) {
                    $this->alert->set('error', 'Bu email adresi kullanılıyor.');
                }
            }

            if (! $this->alert->has('error')) {
                $success = $this->user->create();

                if ($success) {
                    $this->alert->set('success', 'Hesabınız oluşturuldu. Lütfen e-mail adresinize gönderilen doğrulama bağlantısına tıklayarak e-mail adresinizi doğrulayın.');
                    redirect(clink(['@user', 'giris']));
                }
            }

            redirect(clink(['@user', 'create']));
        }

        $this->render('user/create', array());
    }


    public function profile()
    {
        $this->middleware();
        $this->render('user/profile', array());
    }

    /**
     * Erişilmek istenilen sayfanın hangi kullanıcı türene göre olduğunu kontrol eder.
     * Yetkisiz erişim varsa ilgili yönlendirmeyi yapar.
     *
     * @return void
     */
    private function middleware()
    {
        $action = $this->uri->segment(2);

        if (empty($action)) {
            $action = 'index';
        }

        if ($this->auth->logged()) {
            // Üye, ziyaretiler için olan sayfaya erişmek istediğinde
            // Hesap sayfasına yönlendirilir.
            if (in_array($action, $this->guestActions)) {
                redirect(clink(['@user']));
            }
        } else {
            // Ziyaretçi, üyeler için olan sayfaya erişmek istediğinde
            // Giriş sayfasına yönlendirilir.
            if (in_array($action, $this->loggedActions)) {
                redirect(clink(['@user', 'giris']));
            }
        }
    }

} 