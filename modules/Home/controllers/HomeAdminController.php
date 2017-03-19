<?php
use Controllers\AdminController;

class HomeAdminController extends AdminController
{
    public $moduleTitle = 'Home';
    public $module = 'home';
    public $model = 'home';
    public $defaultAction = 'dashboard';

    public $actions = array(
        'dashboard'         => 'list',
        'logout'            => 'list',
        'denied'            => 'list',
        'language'          => 'list',
        'options'           => 'options',
        'password'          => 'password',
        'users'             => 'user-list',
        'userInsert'        => 'user-insert',
        'userUpdate'        => 'user-update',
        'userDelete'        => 'user-delete',
        'groups'            => 'group-list',
        'groupInsert'       => 'group-insert',
        'groupUpdate'       => 'group-update',
        'groupDelete'       => 'group-delete',
        'groupPermsUpdate'  => 'group-update',
    );

    /**
     * İlk giriş ekranı.
     */
    public function dashboard()
    {
        $this->viewData['widgets'] = $this->appmodel->widgets();

        $this->utils->breadcrumb('Önizleme');
        $this->render('dashboard');
    }

    /**
     * Site ayarları.
     *
     * @success
     */
    public function options()
    {
        $options = $this->appmodel->options();

        if ($this->input->post()) {
            $rules = array();

            foreach ($options as $option) {
                if (! empty($option->arguments)) {
                    $rules[$option->name] = array(implode('|', array_keys($option->arguments)), "Lütfen {$option->title} geçerli bir değer veriniz.");
                }
            }

            $this->validate($rules);

            if (! $this->alert->has('error')) {
                $success = $this->appmodel->optionsUpdate($options);

                if ($success) {
                    $this->alert->set('success', 'Kayıt düzenlendi.');
                    $this->makeRedirect('options');
                }
                $this->alert->set('warning', 'Kayıt düzenlenmedi.');
            }
        }

        $this->assets->importEditor();
        $this->utils->breadcrumb("Site Ayarları");

        foreach ($options as $option) {
            $option->arguments['value'] = $option->value;
        }

        $this->viewData['options'] = $options;

        $this->render('options');
    }

    /**
     * Kullanıcı parola değiştirme.
     *
     * @success
     */
    public function password()
    {
        $this->utils->breadcrumb('Parola Değiştir');

        parent::callUpdate([
            'find' => [$this->appmodel, 'user', $this->user->id],
            'update' => [$this->appmodel, 'passwordChange'],
            'validation' => 'passwordValidation',
            'redirect' => ['password']
        ]);

        $this->render('password');
    }

    /**
     * Parola düzenleme validasyon.
     *
     * @param string $action
     */
    public function passwordValidation($action)
    {
        $this->validate([
            'password' => ['required', 'Lüfen parola yazın.']
        ]);
    }

    /**
     * Kullanıcı listesi.
     *
     * @success
     */
    public function users()
    {
        $this->utils->breadcrumb('Kullanıcılar', moduleUri('users'));

        parent::callRecords(array(
            'count' => [$this->appmodel, 'userCount'],
            'all' => [$this->appmodel, 'userAll'],
        ));

        $this->render('users/records');
    }

    /**
     * Kullanıcı ekleme.
     *
     * @success
     */
    public function userInsert()
    {
        $this->utils->breadcrumb('Kullanıcılar', moduleUri('users'));

        parent::callInsert(array(
            'insert' => [$this->appmodel, 'userInsert'],
            'validation' => 'userValidation',
            'redirect' => ['userUpdate', '@id']
        ));

        $this->render('users/insert');
    }

    /**
     * Kullanıcı bilgisi güncelleme.
     *
     * @success
     */
    public function userUpdate()
    {
        $this->utils->breadcrumb('Kullanıcılar', moduleUri('users'));

        parent::callUpdate(array(
            'find' => [$this->appmodel, 'user'],
            'update' => [$this->appmodel, 'userUpdate'],
            'validation' => 'userValidation',
            'redirect' => ['userUpdate', '@id']
        ));

        $this->viewData['groups'] = $this->appmodel->getGroups();
        $this->render('users/update');

    }

    /**
     * Kullanıcı doğrulaması.
     * @param string $action Validasyon türü (insert|update)
     */
    public function userValidation($action)
    {
        $rules = [
            'username' => array('required', 'Lüfen kullanıcı adı yazın.'),
            'group' => array('required|numeric', 'Lütfen kullanıcı grubu seçin.'),
        ];

        if ($action === 'insert') {
            $rules['password'] = array('required', 'Lüfen parola yazın.');
        }

        $this->validate($rules);
    }

    /**
     * Kullanıcı silme.
     *
     * @success
     */
    public function userDelete()
    {
        parent::callDelete(array(
            'delete' => [$this->appmodel, 'userDelete'],
            'find' => [$this->appmodel, 'user']
        ));
    }

    /**
     * Kullanıcı grupları.
     *
     * @success
     */
    public function groups()
    {
        $this->utils->breadcrumb('Gruplar', moduleUri('groups'));

        parent::callRecords(array(
            'count' => [$this->appmodel, 'groupCount'],
            'all' => [$this->appmodel, 'groupAll']
        ));

        $this->render('groups/records');
    }

    /**
     * Kullanıcı grubu ekleme.
     *
     * @success
     */
    public function groupInsert()
    {
        $this->utils->breadcrumb('Gruplar', moduleUri('groups'));

        parent::callInsert(array(
            'insert' => [$this->appmodel, 'groupInsert'],
            'validation' => 'groupValidation',
            'redirect' => ['groupUpdate', '@id']
        ));

        $this->render('groups/insert');

    }

    /**
     * Kullanıcı grubu güncelleme.
     *
     * @success
     */
    public function groupUpdate()
    {
        $this->utils->breadcrumb('Gruplar', moduleUri('groups'));

        parent::callUpdate(array(
            'find' => [$this->appmodel, 'group'],
            'update' => [$this->appmodel, 'groupUpdate'],
            'validation' => 'groupValidation',
            'redirect' => ['groupUpdate', '@id']

        ));

        $this->viewData['modules'] = $this->appmodel->getModules();
        $this->assets->js('public/admin/js/module/home.js');
        $this->render('groups/update');
    }

    /**
     * Kullanıcı grubu doğrulaması.
     */
    public function groupValidation()
    {
        $this->validate([
            'name' => array('required', 'Lüfen grup adı yazın.')
        ]);
    }

    /**
     * Kullanıcı grubu silme.
     *
     * @success
     */
    public function groupDelete()
    {
        parent::callDelete(array(
            'delete' => [$this->appmodel, 'groupDelete'],
            'find' => [$this->appmodel, 'group']
        ));

    }

    /**
     * Kullanıcı grubu yetkilendirme günzellemesi.
     *
     * @success
     */
    public function groupPermsUpdate()
    {
        if (! $record = $this->appmodel->group($this->uri->segment(4))) {
            show_404();
        }

        $success = $this->appmodel->groupPermsUpdate($record);

        if ($success) {
            $this->alert->set('success', 'Yetkiler düzenlendi.', 'perms');
        } else {
            $this->alert->set('warning', 'Yetkilerde değişiklik olmadı.', 'perms');
        }

        redirect(moduleUri('groupUpdate', $record->id));
    }

    /**
     * Giriş kontrolleri.
     *
     * @success
     */
    public function login()
    {
        if ($this->session->userdata('adminlogin') === true) {
            redirect(moduleUri('dashboard'));
        }

        if ($this->input->post()) {

            $this->validate([
                'username' => array('required', 'Lütfen kullanıcı adı yazın.'),
                'password' => array('required', 'Lüfen parola yazın.')
            ]);

            if ($this->alert->has('error')) {
                $this->alert->clear('error');
                $this->alert->set('error', 'Kullanıcı yada Parola hatalı.');
            } else {
                $user = $this->db
                    ->from('admin_users')
                    ->where('username', $this->input->post('username'))
                    ->where('password', md5($this->input->post('password')))
                    ->get()
                    ->row();

                if ($user) {
                    $this->session->set_userdata('adminlogin', true);
                    $this->session->set_userdata('adminuser', $user);

                    redirect(moduleUri('dashboard'));
                } else {
                    $this->alert->set('error', 'Kullanıcı yada Parola hatalı.');
                }
            }
        }

        $this->load->view('helpers/master', array(
            'view' => 'helpers/home/login'
        ));
    }

    /**
     * Çıkış, oturumu kapatma.
     *
     * @success
     */
    public function logout()
    {
        $this->session->unset_userdata('adminlogin');
        $this->session->unset_userdata('adminuser');

        redirect(moduleUri('login'));
    }

    /**
     * Yetkisiz sayfa erişimi uyarı sayfası.
     *
     * @sucess
     */
    public function denied()
    {
        $this->load->view('helpers/master', array(
            'view' => 'helpers/home/denied'
        ));
    }

    /**
     * Aktif panel dilini değiştirme.
     *
     * @success
     */
    public function language()
    {
        $languages = $this->config->item('languages');
        $segment = $this->uri->segment(4);
        $reference = $this->input->get('ref');

        if ($languages && $segment) {
            if (array_key_exists($segment, $languages)) {
                $this->session->set_userdata('language', $segment);
            }
        }

        if (! empty($reference)) {
            redirect($reference);
        } else {
            redirect('/');
        }
    }
} 