<?php

use Sirius\Application\Model;

class Social extends Model
{
    private $table = 'socials';
    private $items = array();

    /**
     * Tüm kayıtları döndürür.
     *
     * @return mixed
     */
    public function all()
    {
        if (empty($this->items)) {
            $this->items = $this->db
                ->from($this->table)
                ->where('status', 'published')
                ->where('language', $this->language)
                ->order_by('order', 'asc')
                ->get()
                ->result();
        }

        return $this->items;
    }

}