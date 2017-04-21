<?php

use Sirius\Admin\Installer as InstallManager;


class Installer extends InstallManager
{

    /**
     * Tabloların varlığı kontrol edilmesi için konulabilir.
     *
     * @var array
     */
    public $tables = array(
        'users',
    );


    /**
     * Rotasyon tanımlamaları.
     *
     * @var array
     */
    public $routes = array(
        'tr' => array(
            'route' => array(
                'hesap/giris' => 'User/UserController/login',
                'hesap/cikis' => 'User/UserController/logout',
                'hesap/olustur' => 'User/UserController/create',
                'hesap/profil' => 'User/UserController/profile',
                'hesap/parola' => 'User/UserController/password',
                'hesap/avatar' => 'User/UserController/avatar',
                'hesap/bildirim' => 'User/UserController/notification',
                'hesap' => 'User/UserController/index',
            ),
            'uri' => 'hesap'
        ),
    );

}