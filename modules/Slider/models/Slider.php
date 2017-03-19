<?php

use Sirius\Application\Model;

class Slider extends Model
{
    private $table = 'sliders';

    /**
     * Tüm kayıtları döndürür
     *
     * @param array $paginate
     * @return array
     */
    public function all($paginate = [])
    {
        $this->setPaginate($paginate);

        return $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->get()
            ->result();
    }

}