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

    /**
     * Varsayılan işlemler.
     */
    public function insertData()
    {
        $languages = $this->config->item('languages');
        $insert = array();

        foreach ($languages as $language => $label) {
            $data = array(
                array(
                    'module' => 'author',
                    'name' => 'title',
                    'title' => 'Sayfa Başlığı',
                    'value' => 'Yazarlar',
                    'type' => 'text',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'module' => 'author',
                    'name' => 'metaTitle',
                    'title' => 'Meta Başlığı',
                    'value' => 'Yazarlar',
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'author',
                    'name' => 'metaDescription',
                    'title' => 'Meta Tanımı',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'author',
                    'name' => 'metaKeywords',
                    'title' => 'Meta Anahtar Kelimeleri',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),

            );

            $insert = array_merge($insert, $data);
        }

        $this->db->insert_batch('module_arguments', $insert);
    }

}