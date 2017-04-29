<?php

use Models\AdminModel;

class CommentAdmin extends AdminModel
{
    protected $table = 'comments';


    public function find($id)
    {
        return $this->db
            ->select("{$this->table}.*, users.username userName, news.title newsTitle")
            ->from($this->table)
            ->join('users', "users.id = {$this->table}.userId")
            ->join('news', "news.id = {$this->table}.newsId")
            ->where("{$this->table}.id", $id)
            ->get()
            ->row();
    }

    public function all($paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        return $this->db
            ->select("{$this->table}.*, users.username userName, news.title newsTitle")
            ->from($this->table)
            ->join('users', "users.id = {$this->table}.userId")
            ->join('news', "news.id = {$this->table}.newsId")
            ->order_by("{$this->table}.id", 'asc')
            ->get()
            ->result();
    }


    public function count()
    {
        $this->setFilter();

        return $this->db
            ->from($this->table)
            ->count_all_results();
    }


    public function update($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'content' => $this->input->post('content'),
                'status' => $this->input->post('status'),
                'updatedAt' => $this->date->set()->mysqlDatetime()
            ));

        if ($this->db->affected_rows() > 0) {
            $record = $this->find($record->id);

            return $record;
        }

        return false;
    }



    public function delete($data)
    {
        return parent::callDelete($this->table, $data);
    }

}