<?php

namespace Sirius\Application;


class ActuatorModel extends Model
{

    public $status = false;
    public $parent = false;
    public $images = false;
    public $imageTable;
    public $orders = array();

    /**
     * Kayıt bulma
     *
     * @param $value
     * @param string $column
     * @return object
     */
    public function find($value, $column = 'id')
    {
        $this->initStatus();

        $result = $this->db
            ->from($this->table)
            ->where($column, $value)
            ->where('language', $this->language)
            ->get()
            ->row();

        if ($result) {
            if ($this->parent === true) {
                $result->childs = $this->childs($result);
                $result->parent = $this->parent($result);
            }

            if ($this->images === true) {
                $result->images = $this->images($result);
            }

        }

        return $result;
    }

    /**
     * Kayıtları bulma
     *
     * @param array $values
     * @param string $column
     * @return array
     */
    public function findIn(array $values, $column = 'id')
    {
        $values = array_unique($values);

        $this->initStatus();

        $results = $this->db
            ->from($this->table)
            ->where_in($column, $values)
            ->where('language', $this->language)
            ->get()
            ->result();

        if ($this->parent === true) {
            foreach ($results as $result) {
                $result->childs = $this->childs($result);
                $result->parent = $this->parent($result);
            }
        }

        if ($this->images === true) {
            foreach ($results as $result) {
                $result->images = $this->images($result);

            }
        }
    }

    /**
     * Slug'a göre kaydı bulur.
     *
     * @param $slug
     * @return object
     */
    public function findBySlug($slug)
    {
        return $this->find($slug, 'slug');
    }


    /**
     * Tüm kayıtları döndürür.
     *
     * @param array $paginate
     * @return array
     */
    public function all($paginate = [])
    {
        $this->setPaginate($paginate);
        $this->initStatus();

        foreach ($this->orders as $column => $sort) {
            $this->db->order_by($column, $sort);
        }

        return $this->db
            ->from($this->table)
            ->where('language', $this->language)
            ->get()
            ->result();
    }

    /**
     * Toplam kayıt sayısı.
     *
     * @return int
     */
    public function count()
    {
        $this->initStatus();

        return $this->db
            ->from($this->table)
            ->where('language', $this->language)
            ->count_all_results();
    }

    /**
     * Kaydın üst kaydını döndürür.
     *
     * @param $record
     * @return bool
     */
    public function parent($record)
    {
        if ($record->parentId > 0) {
            $this->initStatus();

            $result = $this->db
                ->from($this->table)
                ->where('id', $record->parentId)
                ->where('language', $this->language)
                ->get()
                ->row();

            if ($result) {
                $result->childs = $this->childs($result);
            }

            return $result;
        }

        return false;
    }

    /**
     * Kaydın alt kayıtlarını döndürür.
     *
     * @param $record
     * @return mixed
     */
    public function childs($record)
    {
        $this->initStatus();

        return $this->db
            ->from($this->table)
            ->where('parentId', $record->id)
            ->where('language', $this->language)
            ->get()
            ->result();
    }


    /**
     * Kaydın resim kayıtlarını döndürür.
     *
     * @param $record
     * @param null|int $limit
     * @return mixed
     */
    public function images($record, $limit = null)
    {
        if (! empty($limit)) {
            $this->db->limit($limit);
        }

        return $this->db
            ->from($this->imageTable)
            ->where('parentId', $record->id)
            ->order_by('order', 'asc')
            ->order_by('id', 'desc')
            ->get()
            ->result();
    }


    private function initStatus()
    {
        if ($this->status === true) {
            $this->db->where('status', 'published');
        }
    }

}