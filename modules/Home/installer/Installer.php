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
        'admin_groups',
        'admin_perms',
        'admin_users',
        'modules',
        'module_arguments',
        'options',
        'menus',
        'categories',
        'news',
        'galleries',
        'gallery_images',
        'users',
        'slider',
        'socials',
    );

    /**
     * Rotasyon tanımlamaları.
     *
     * @var array
     */
    public $routes = array(
        // Türkçe
        'tr' => array(
            'route' => array(
                // Search
                'ara' => 'Search/SearchController/search',
                // Gallery
                'galeriler' => 'Gallery/GalleryController/index',
                'galeriler/([a-zA-Z0-9_-]+)' => 'Gallery/GalleryController/view/$1',
                // User
                'hesap/giris' => 'User/UserController/login',
                'hesap/cikis' => 'User/UserController/logout',
                'hesap/olustur' => 'User/UserController/create',
                'hesap/profil' => 'User/UserController/profile',
                'hesap/parola' => 'User/UserController/password',
                'hesap/avatar' => 'User/UserController/avatar',
                'hesap/dogrula/(.+)' => 'User/UserController/verify/$1',
                'hesap/parolami-unuttum' => 'User/UserController/forgotPassword',
                'hesap/parolami-sifirla/(.+)' => 'User/UserController/resetPassword/$1',
                'hesap' => 'User/UserController/index',
                // Comment
                'yorum/yaz' => 'Comment/CommentController/create',
                // News
                '([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)' => 'News/NewsController/view/$1/$2',
                // Categories
                '([a-zA-Z0-9_-]+)' => 'Category/CategoryController/view/$1',
            )
        ),
    );

    public function saveModules()
    {
        $modules = array(
            'module' => 'Mdüller',
            'category' => 'Kategoriler',
            'news' => 'Haberler',
            'gallery' => 'Galeriler',
            'menu' => 'Menü Yönetimi',
            'slider' => 'Slider',
            'user' => 'Üyeler',
            'comment' => 'Yorumlar',
            'search' => 'Arama',
            'social' => 'Sosyal Medya',
        );

        foreach ($modules as $module => $title) {
            $this->db->insert('modules', array(
                'title' => $title,
                'name' => $module,
                'modified' => 0,
                'permissions' => '',
                'type' =>  null,
                'icon' =>  null,
                'menuPattern' => null,
                'controller' => '',
            ));
        }
    }

    public function insertMenuData()
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


    public function insertHomeData()
    {
        $languages = $this->config->item('languages');
        $insert = array();

        foreach ($languages as $language => $label) {
            $insert = array(
                array(
                    'name' => 'metaTitle',
                    'title' => 'Site Başlığı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'name' => 'metaDescription',
                    'title' => 'Site Tanımı',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'name' => 'metaKeywords',
                    'title' => 'Site Anahtar Kelimeleri',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'name' => 'customMeta',
                    'title' => 'Özel Metalar',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'name' => 'smtpHost',
                    'title' => 'Smtp Sunucusu',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'name' => 'smtpPort',
                    'title' => 'Smtp Port',
                    'value' => '587',
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'name' => 'smtpUser',
                    'title' => 'Smtp Kullanıcı Adı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'name' => 'smtpPass',
                    'title' => 'Smtp Parola',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'name' => 'smtpFromEmail',
                    'title' => 'Gönderici Email Adresi',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                )
            );
        }

        $this->db->insert_batch('options', $insert);
    }



    public function insertGalleryData()
    {

        $languages = $this->config->item('languages');
        $insert = array();

        foreach ($languages as $language => $label) {
            $data = array(
                array(
                    'module' => 'gallery',
                    'name' => 'title',
                    'title' => 'Sayfa Başlığı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'module' => 'gallery',
                    'name' => 'metaTitle',
                    'title' => 'Meta Başlığı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'gallery',
                    'name' => 'metaDescription',
                    'title' => 'Meta Tanımı',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'gallery',
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


    public function insertSearchData()
    {
        $languages = $this->config->item('languages');
        $insert = array();

        foreach ($languages as $language => $label) {
            $data = array(
                array(
                    'module' => 'search',
                    'name' => 'title',
                    'title' => 'Sayfa Başlığı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array('required' => true)),
                    'language' => $language,
                ),
                array(
                    'module' => 'search',
                    'name' => 'metaTitle',
                    'title' => 'Meta Başlığı',
                    'value' => null,
                    'type' => 'text',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'search',
                    'name' => 'metaDescription',
                    'title' => 'Meta Tanımı',
                    'value' => null,
                    'type' => 'textarea',
                    'arguments' => json_encode(array()),
                    'language' => $language,
                ),
                array(
                    'module' => 'search',
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