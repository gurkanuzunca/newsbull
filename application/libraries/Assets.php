<?php


class Assets
{
    private $assets = [];


    /**
     * Magic method.
     * Kullanılan method ismine göre asset kaydı yapar.
     *
     * @param $name
     * @param $arguments
     * @return bool
     */
    public function __call($name, $arguments)
    {
        return $this->set($name, $arguments);
    }

    /**
     * Javascript dosyası tanımlar.
     *
     * @param array $sources
     * @param null|string $module
     * @return mixed
     */
    public function js($sources = [], $module = null)
    {
        return $this->set('js', $sources, $module);
    }

    /**
     * Css dosyası tanımlar.
     *
     * @param array $sources
     * @param null|string $module
     * @return mixed
     */
    public function css($sources = [], $module = null)
    {
        return $this->set('css', $sources, $module);
    }


    /**
     * Javascript ve css dosyalarını sisteme tanımlar veya dosyaları göndürür.
     *
     * @param $type
     * @param array $sources
     * @param null|string $module
     * @return mixed
     */
    public function set($type, $sources = [], $module = null)
    {
        if (empty($sources)) {
            if (isset($this->assets[$type])) {
                return $this->assets[$type];
            }

            return array();
        }

        if (! is_array($sources)) {
            $sources = array($sources);
        }

        if (! isset($this->assets[$type])) {
            $this->assets[$type] = [];
        }

        if (! is_null($module)) {
            $sources = array_map(function($source) use ($module) {
                // return 'modules/'. ucfirst($module) .'/'. $source;
                // İlk harf büyütme pasif duruma göre aktif edilecek.
                return 'modules/'. ucfirst($module) .'/'. $source;
            }, $sources);
        }

        $this->assets[$type] = array_merge($this->assets[$type], $sources);

        return array();
    }


    /**
     * Editör javascript dosyalarını tanımlar.
     */
    public function importEditor()
    {
        $this->set('js', [
            'public/admin/plugin/ckeditor/ckeditor.js',
            'public/admin/plugin/ckfinder/ckfinder.js'
        ]);
    }

    /**
     * Plupload javascript dosyalarını tanımlar.
     */
    public function importPlupload()
    {
        $this->set('js', [
            'public/admin/plugin/plupload/plupload.js',
            'public/admin/plugin/plupload/plupload.flash.js',
            'public/admin/plugin/plupload/plupload.html4.js',
            'public/admin/plugin/plupload/plupload.html5.js',
        ]);
    }
}