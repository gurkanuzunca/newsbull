<?php

use Models\AdminModel;

class UserAdmin extends AdminModel
{
    protected $table = 'users';
    private $hashAlgo = 'sha256';


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
            ->from($this->table)
            ->order_by("id", 'asc')
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
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => hash($this->hashAlgo, $this->input->post('password')),
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'avatar' => $data['image']->name,
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
        $password = $this->input->post('password');

        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => empty($password) ? $record->password : hash($this->hashAlgo, $password),
                'name' => $this->input->post('name'),
                'surname' => $this->input->post('surname'),
                'avatar' => $data['image']->name,
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
                'public/upload/user/avatar/'. $record->avatar
            ]);
        }

        return true;
    }


}