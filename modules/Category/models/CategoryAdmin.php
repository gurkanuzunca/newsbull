<?php

use Models\AdminModel;

class CategoryAdmin extends AdminModel
{
    protected $table = 'categories';


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
            'slug' => $this->makeSlug(),
            'showHome' => $this->input->post('showHome'),
            'order' => $order,
            'metaTitle' => $this->input->post('metaTitle'),
            'metaDescription' => $this->input->post('metaDescription'),
            'metaKeywords' => $this->input->post('metaKeywords'),
            'status' => $this->input->post('status'),
            'language' => $this->language,
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            $record = $this->find($insertId);
            $this->checkSlug($this->table, $record);

            return $record;
        }

        return false;
    }


    public function update($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'title' => $this->input->post('title'),
                'slug' => $this->makeSlug(),
                'showHome' => $this->input->post('showHome'),
                'metaTitle' => $this->input->post('metaTitle'),
                'metaDescription' => $this->input->post('metaDescription'),
                'metaKeywords' => $this->input->post('metaKeywords'),
                'status' => $this->input->post('status'),
                'updatedAt' => $this->date->set()->mysqlDatetime()
            ));

        if ($this->db->affected_rows() > 0) {
            $record = $this->find($record->id);
            $this->checkSlug($this->table, $record);

            return $record;
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