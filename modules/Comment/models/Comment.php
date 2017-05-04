<?php

use Models\BaseModel;

/**
 * Class Comment
 *
 * @property \User $user
 * @property \News $news
 * @property \Category $category
 */
class Comment extends BaseModel
{
    private $table = 'comments';

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
            ->get()
            ->result();
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

        return $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->order_by('id', 'desc')
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
            ->count_all_results();
    }

    /**
     * Tüm kayıtları Üye bilgileri ile birlikte döndürür.
     *
     * @param array $paginate
     * @return bool
     */
    public function allWithUser($paginate = [])
    {
        $comments = $this->all($paginate);

        if ($comments) {
            $this->load->model('user/user');

            $userIds = $this->getColumnData($comments, 'userId');
            $users = $this->user->findIn($userIds);
            $this->setRelationOne('user', $comments, 'userId', $users, 'id');
        }

        return $comments;
    }

    /**
     * Tüm kayıtları Haber bilgileri ile birlikte döndürür.
     *
     * @param array $paginate
     * @return bool
     */
    public function allWithNews($paginate = [])
    {
        $comments = $this->all($paginate);

        if ($comments) {
            $this->load->model('news/news');
            $this->load->model('category/category');

            $newIds = $this->getColumnData($comments, 'newsId');
            $news = $this->news->findIn($newIds);
            $this->setRelationOne('news', $comments, 'newsId', $news, 'id');

            $categoryIds = $this->getColumnData($news, 'categoryId');
            $categories = $this->category->findIn($categoryIds);
            $this->setRelationOne('category', $news, 'categoryId', $categories, 'id');

        }

        return $comments;
    }

    /**
     * Yeni yorum oluşturma.
     *
     * @param object $user
     * @param object $news
     * @return bool|string
     */
    public function create($user, $news)
    {
        $this->db->insert($this->table, array(
            'userId' => $user->id,
            'newsId' => $news->id,
            'content' => $this->input->post('content'),
            'status' => 'unpublished',
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return true;
        }

        return false;
    }
}