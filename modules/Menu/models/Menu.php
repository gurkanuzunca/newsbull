<?php

use Sirius\Application\Model;

class Menu extends Model
{
    private $menus = array();

    /**
     * İstenilen menüyü döndürür.
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        if (empty($this->menus)) {
            $this->load();
        }

        if (isset($this->menus[$name])) {
            return $this->menus[$name];
        }
    }




    /**
     * Menu constructor.
     * Ana menüleri ve alt kayıtlarını çeker.
     */
    private function load()
    {
        $results = $this->db
            ->from('menus')
            ->where('parentId IS NULL')
            ->where('language', $this->language)
            ->get()
            ->result();


        foreach ($results as $result) {
            $this->menus[$result->name] = $this->childs($result->id);
        }
    }


    /**
     * Menü alt kayıtlarını recursive olarak çeker.
     *
     * @param $parentId
     * @return mixed
     */
    private function childs($parentId)
    {
        $results = $this->db
            ->from('menus')
            ->where('parentId', $parentId)
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by('id', 'asc')
            ->get()
            ->result();

        foreach ($results as $result) {
            $result->childs = $this->childs($result->id);
        }

        return $results;
    }

}