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
        'menus'
    );

    public function insertData()
    {
        $languages = $this->config->item('languages');

        foreach ($languages as $language => $label) {
            $this->db->insert('menus', array(
                'name' => 'main',
                'title' => 'Anamenü',
                'language' => $language
            ));

            $this->db->insert('menus', array(
                'name' => 'footer',
                'title' => 'Altmenü',
                'language' => $language
            ));
        }
    }

}