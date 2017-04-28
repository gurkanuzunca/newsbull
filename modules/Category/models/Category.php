<?php

use Models\BaseModel;

/**
 * Class Category
 *
 * @property \News $news
 */
class Category extends BaseModel
{
    private $table = 'categories';

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


    public function findWithNews($value, $column = 'id', $paginate = [])
    {
        $category = $this->find($value, $column);

        if ($category) {
            $this->news($category, $paginate);
        }

        return $category;
    }

    /**
     * Kategorinin haberlerini döndürür.
     *
     * @param $category
     * @param array $paginate
     */
    public function news($category, $paginate = [])
    {
        $this->load->model('news/news');
        $this->db->where('categoryId', $category->id);
        $category->news = $this->news->allWithCategory($paginate);
    }

    /**
     * Kategornin haber sayısını göndürür.
     *
     * @param $category
     */
    public function newsCount($category)
    {
        $this->load->model('news/news');
        $this->db->where('categoryId', $category->id);
        $category->newsCount = $this->news->count();
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
        $categories =  $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->where('showHome', true)
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->get()
            ->result();

        foreach ($categories as $category) {
            $this->news($category, ['limit' => $limit]);
        }

        return $categories;
    }
}