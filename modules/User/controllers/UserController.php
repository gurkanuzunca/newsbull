<?php

use Controllers\BaseController;

/**
 * Class UserController
 *
 * @property Auth $auth
 * @property User $user
 * @property UserMailer $usermailer
 */
class UserController extends BaseController
{
    public $module = 'user';

    /**
     * Üyelere özel sayfalar.
     * @var array
     */
    private $loggedActions = array('index', 'profil', 'parola', 'avatar', 'bildirim', 'cikis');

    /**
     * Ziyaretçiye özel sayfalar.
     * @var array
     */
    private $guestActions = array('giris', 'dogrula', 'parolami-unuttum', 'parolami-sifirla');

    /**
     * Üye dashboard
     */
    public function index()
    {
        $this->middleware();
        $this->render('user/index', array());
    }

    /**
     * Profil sayfası
     */
    public function profile()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->validate([
                'name' => array('required', 'Lütfen adınızı yazınız.'),
                'surname' => array('required', 'Lütfen soyadınızı yazınız.'),
                'username' => array('required', 'Lütfen kullanıcı adı yazınız.')
            ]);

            if (! $this->alert->has('error')) {
                $success = $this->user->update($this->getUser());

                if ($success) {
                    $this->alert->set('success', 'Profiliniz başarıyla güncellendi.');
                    redirect(clink(['@user', 'profil']));
                }

                $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
            }

            redirect(clink(['@user', 'profil']));
        }

        $this->render('user/profile', array());
    }

    /**
     * Parola sayfası
     */
    public function password()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->validate([
                'oldpassword' => array('required', 'Lütfen şuanki parolanızı yazınız.'),
                'newpassword' => array('required|min_length[6]', 'Lütfen geçerli bir parola yazınız.')
            ]);

            if (! $this->alert->has('error')) {
                if ($this->user->matchPassword($this->getUser()) === false) {
                    $this->alert->set('error', 'Şuanki parolanız hatalı.');
                }
            }

            if (! $this->alert->has('error')) {
                $success = $this->user->changePassword($this->getUser());

                if ($success) {
                    $this->alert->set('success', 'Parolanız başarıyla güncellendi.');
                    redirect(clink(['@user', 'parola']));
                }

                $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
            }

            redirect(clink(['@user', 'parola']));
        }

        $this->render('user/password', array());
    }


    /**
     * Avatar güncelleme sayfası
     */
    public function avatar()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->image->setUploadInput('avatar')
                ->required()
                ->setMinSizes(300, 300)
                ->addProcess('user/avatar', ['thumbnail' => [300, 300]]);

            // Eski resim varsa silinmesi için.
            if (! empty($this->getUser()->avatar)) {
                $this->image->setDefaultImage($this->getUser()->avatar);
            }

            $avatar = $this->image->save();

            if (! $this->alert->has('error')) {
                $success = $this->user->changeAvatar($this->getUser(), $avatar);

                if ($success) {
                    $this->alert->set('success', 'Avatar başarıyla güncellendi.');
                    redirect(clink(['@user', 'avatar']));
                }

                $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
            }

            redirect(clink(['@user', 'avatar']));
        }

        $this->render('user/avatar', array());
    }

    /**
     * Üye giriş sayfası
     */
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
            }

            $this->alert->clear('error');
            $this->alert->set('error', 'Giriş bilgileri hatalı.');

            redirect(clink(['@user', 'giris']));
        }

        $this->render('user/login', array());
    }

    /**
     * Oturum kapatma.
     */
    public function logout()
    {
        $this->auth->logout();
        redirect(clink(['@home']));
    }

    /**
     * Yeni kullanıcı oluşturma.
     */
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
                $verifyToken = $this->user->create();

                if ($verifyToken) {
                    $this->load->library('user/UserMailer');
                    $this->usermailer->sendEmailVerify($this->input->post('email'), array('token' => $verifyToken));
                    $this->alert->set('success', 'Hesabınız oluşturuldu. Lütfen e-mail adresinize gönderilen doğrulama bağlantısına tıklayarak e-mail adresinizi doğrulayın.');

                    redirect(clink(['@user', 'giris']));
                }

                $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
            }

            redirect(clink(['@user', 'olustur']));
        }

        $this->render('user/create', array());
    }

    /**
     * Kullanıcı doğrulama.
     *
     * @param string $token
     */
    public function verify($token)
    {
        $this->middleware();
        $success = false;

        $user = $this->user->findByCriteria(['verifyToken' => $token, 'status' => 'unverified']);

        if ($user) {
            $success = $this->user->verify($user);
        }

        if ($success === true) {
            $this->alert->set('success', 'Tebrikler! E-mail adresiniz doğrulandı.');
        } else {
            $this->alert->set('error', 'Doğrulama işlemi yapılamadı.');
        }

        redirect(clink(['@user', 'giris']));
    }

    /**
     * Parolamı unuttum. Parola sıfırlama talebi oluşturma.
     */
    public function forgotPassword()
    {
        $this->middleware();

        if ($this->input->post()) {
            $this->validate([
                'email' => array('required', ''),
            ]);

            if (! $this->alert->has('error')) {
                $user = $this->user->findByCriteria([
                    'email' => $this->input->post('email')
                ]);

                if ($user) {
                    $this->user->createPasswordToken($user);
                    $this->load->library('user/UserMailer');
                    $this->usermailer->sendForgotPassword($user->email, array('token' => $user->passwordToken));

                    $this->alert->set('success', 'Parola sıfırlama için e-mail adresinizi kontrol ediniz.');
                    redirect(clink(['@user', 'parolami-unuttum']));
                }
            }

            $this->alert->clear('error');
            $this->alert->set('error', 'E-mail adresi bulunamadı.');

            redirect(clink(['@user', 'parolami-unuttum']));
        }

        $this->render('user/forgot-password', array());
    }

    /**
     * Parola sıfırlama.
     *
     * @param string $token
     */
    public function resetPassword($token)
    {
        $this->middleware();
        $user = $this->user->findByCriteria(['passwordToken' => $token, 'passwordTokenDate >' => $this->date->set('-1 hour')->mysqlDatetime()]);

        if (! $user) {
            $this->alert->set('error', 'Parolamı unuttum? bağlantısı doğrulanamadı. Lütfen tekrar parola sıfırlama talebinde bulununuz.');
            redirect(clink(['@user', 'parolami-unuttum']));
        }

        if ($this->input->post()) {
            $this->validate([
                'password' => array('required|min_length[6]', 'Lütfen geçerli bir parola yazınız.'),
            ]);

            if (! $this->alert->has('error')) {
                $success = $this->user->resetPassword($user);

                if ($success === true) {
                    $this->alert->set('success', 'Parola sıfırlama işlemi tamamlandı. Giriş yapabilirsiniz.');

                    redirect(clink(['@user', 'giris']));
                } else {
                    $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
                }
            }

            redirect(clink(['@user', 'parolami-sifirla', $token]));
        }

        $this->render('user/reset-password', array());
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