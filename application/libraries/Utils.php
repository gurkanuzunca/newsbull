<?php


class Utils
{

    private $ci;
    private $breadcrumbs = array();

    public function __construct(array $config = array())
    {
        $this->ci =& get_instance();
    }


    /**
     * Navigasyon elemanı tanımlar.
     *
     * @param string $title
     * @param string $url
     * @return void
     */
    public function breadcrumb($title, $url = '')
    {
        if (is_array($title)) {
            $this->breadcrumbs = array_merge($this->breadcrumbs, $title);
        } else {
            $this->breadcrumbs[] = array('title' => $title, 'url' => $url);
        }
    }

    /**
     * @return array
     */
    public function breadcrumbs()
    {
        return $this->breadcrumbs;
    }




    /**
     * Belirtilen dosyaları siler.
     *
     * @param string $path
     */
    public function deleteFile($path)
    {
        if (is_array($path)){
            foreach ($path as $p){
                @unlink($p);
            }
        } else {
            @unlink($path);
        }
    }


}
