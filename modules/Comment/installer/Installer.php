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
        'comments',
    );


    /**
     * Rotasyon tanımlamaları.
     *
     * @var array
     */
    public $routes = array(
        'tr' => array(
            'route' => array(
                'yorum/yaz' => 'Comment/CommentController/create',
            ),
            'uri' => 'yorum'
        ),
    );

}