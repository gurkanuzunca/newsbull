<?php

use Models\AdminModel;

class SliderAdmin extends AdminModel
{
    protected $table = 'sliders';


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
            'summary' => $this->input->post('summary'),
            'link' => $this->input->post('link'),
            'image' => $data['image']->name,
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
                'summary' => $this->input->post('summary'),
                'link' => $this->input->post('link'),
                'image' => $data['image']->name,
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
        $records = parent::callDelete($this->table, $data, true);

        if (empty($records)){
            return false;
        }

        foreach ($records as $record){
            $this->utils->deleteFile([
                'public/upload/slider/'. $record->image
            ]);
        }

        return true;
    }


    public function order($ids)
    {
        return parent::callOrder($this->table, $ids);
    }

}