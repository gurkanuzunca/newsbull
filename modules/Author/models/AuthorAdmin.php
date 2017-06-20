<?php

use Models\AdminModel;

class AuthorAdmin extends AdminModel
{
    protected $table = 'authors';


    public function find($id)
    {
        return $this->db
            ->from($this->table)
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function all($paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        return $this->db
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM news WHERE news.userId = {$this->table}.id) news")
            ->from($this->table)
            ->order_by("id", 'desc')
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


    public function insert($data = array())
    {
        $this->db->insert($this->table, array(
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'image' => $data['image']->name,
            'about' => $this->input->post('about'),
            'status' => $this->input->post('status'),
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            $record = $this->find($insertId);

            return $record;
        }

        return false;
    }


    public function update($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'image' => $data['image']->name,
                'about' => $this->input->post('about'),
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
        $records = parent::callDelete($this->table, $data, true);

        if (empty($records)){
            return false;
        }

        foreach ($records as $record){
            $this->utils->deleteFile([
                'public/upload/author/'. $record->image
            ]);
        }

        return true;
    }


}