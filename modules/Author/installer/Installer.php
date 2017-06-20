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
        'authors',
    );

    /**
     * Rotasyon tanımlamaları.
     *
     * @var array
     */
    public $routes = array(
        'tr' => array(
            'route' => array(
                '@uri' => 'Author/AuthorController/index',
                '@uri/([a-zA-Z0-9_-]+)' => 'Author/AuthorController/view/$1',
            ),
            'uri' => 'yazarlar'
        ),
    );

}