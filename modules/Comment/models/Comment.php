<?php

use Models\BaseModel;

/**
 * Class Comment
 *
 * @property \User $user
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
     * Tüm kayıtları Üye bilgileri ile birlikte döndürür.
     *
     * @param array $paginate
     * @return array
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
}