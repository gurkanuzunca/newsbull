<?php

use Sirius\Application\Model;

class Gallery extends Model
{
    private $table = 'galleries';
    private $imageTable = 'gallery_images';

    /**
     * Kayıt bulma
     *
     * @param $value
     * @param string $column
     * @return object
     */
    public function find($value, $column = 'id')
    {
        return $this->db
            ->from($this->table)
            ->where($column, $value)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->get()
            ->row();
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

        return $this->db
            ->from($this->table)
            ->where_in($column, $values)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->get()
            ->result();
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


    public function findWithImages($value, $column = 'id', $paginate = [])
    {
        $gallery = $this->find($value, $column);

        if ($gallery) {
            $this->images($gallery, $paginate);
        }

        return $gallery;
    }


    public function images($gallery, $paginate = [])
    {
        $this->setPaginate($paginate);

        $gallery->images = $this->db
            ->from($this->imageTable)
            ->where('galleryId', $gallery->id)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->get()
            ->result();
    }


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
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM {$this->imageTable} WHERE {$this->imageTable}.galleryId = {$this->table}.id) imageCount")
            ->from($this->table)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->order_by('order', 'asc')
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
        return $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->where('language', $this->language)
            ->count_all_results();
    }

    /**
     * Anasayfada gösterilen kategorileri çeker.
     *
     * @param int $limit Kaç adet haber çekileceğinı belirler.
     * @return array
     */
    public function showHome($limit)
    {
        $this->db->where('showHome', true);
        $galleries =  $this->all(['limit' => $limit]);

        return $galleries;
    }


    public function increaseVisit($record, $session = false)
    {

        $visitedGalleries = $session === true ? $this->session->userdata('visitedGalleries') : array();

        if (! is_array($visitedGalleries)) {
            $visitedGalleries = array();
        }

        if (! in_array($record->id, $visitedGalleries)) {
            $this->db
                ->where('id', $record->id)
                ->update($this->table, array(
                    'visited' => $record->visited + 1
                ));

            if ($this->db->affected_rows() > 0) {
                $record->visited = $record->visited +1;
                $visitedGalleries[] = $record->id;

                if ($session === true) {
                    $this->session->set_userdata('visitedGalleries', $visitedGalleries);
                }

                return true;
            }
        }

        return false;
    }


    public function search($query)
    {
        $this->db->like('title', $query)->or_like('summary', $query);
        return $this->all();
    }
}