<?php

use Models\AdminModel;

class SocialAdmin extends AdminModel
{
    protected $table = 'socials';


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
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by("id", 'asc')
            ->get()
            ->result();
    }


    public function count()
    {
        $this->setFilter();

        return $this->db
            ->from($this->table)
            ->where('language', $this->language)
            ->count_all_results();
    }


    public function insert($data = array())
    {
        $order = $this->makeLastOrder($this->table);

        $this->db->insert($this->table, array(
            'title' => $this->input->post('title'),
            'icon' => $this->input->post('icon'),
            'link' => $this->input->post('link'),
            'order' => $order,
            'status' => $this->input->post('status'),
            'language' => $this->language,
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return $this->find($insertId);
        }

        return false;
    }


    public function update($record, $data = array())
    {

        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'title' => $this->input->post('title'),
                'icon' => $this->input->post('icon'),
                'link' => $this->input->post('link'),
                'status' => $this->input->post('status'),
                'updatedAt' => $this->date->set()->mysqlDatetime()
            ));

        if ($this->db->affected_rows() > 0) {
            return $this->find($record->id);
        }

        return false;
    }



    public function delete($data)
    {
        return parent::callDelete($this->table, $data);
    }


    public function order($ids)
    {
        return parent::callOrder($this->table, $ids);
    }

}