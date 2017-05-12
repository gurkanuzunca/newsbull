<?php

use Models\AdminModel;

class GalleryAdmin extends AdminModel
{
    protected $table = 'galleries';
    protected $imageTable = 'gallery_images';


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
            ->select("{$this->table}.*, (SELECT COUNT(id) FROM {$this->imageTable} WHERE {$this->imageTable}.galleryId = {$this->table}.id) images")
            ->from($this->table)
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by("id", 'desc')
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
            'summary' => $this->input->post('summary'),
            'showHome' => $this->input->post('showHome'),
            'image' => $data['image']->name,
            'content' => $this->input->post('content'),
            'design' => $this->input->post('design'),
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
                'summary' => $this->input->post('summary'),
                'showHome' => $this->input->post('showHome'),
                'image' => $data['image']->name,
                'content' => $this->input->post('content'),
                'design' => $this->input->post('design'),
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
        $records = parent::callDelete($this->table, $data, true);

        if (empty($records)){
            return false;
        }

        foreach ($records as $record){
            $this->utils->deleteFile([
                'public/upload/gallery/'. $record->image
            ]);
        }

        return true;
    }


    public function order($ids)
    {
        return parent::callOrder($this->table, $ids);
    }


    public function image($id)
    {
        return $this->db
            ->from($this->imageTable)
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function imageAll($parent, $paginate = [])
    {
        $this->setFilter();
        $this->setPaginate($paginate);

        return $this->db
            ->from($this->imageTable)
            ->where('galleryId', $parent->id)
            ->where('language', $this->language)
            ->order_by('order', 'asc')
            ->order_by('id', 'asc')
            ->get()
            ->result();
    }

    public function imageCount($parent)
    {
        $this->setFilter();

        return $this->db
            ->from($this->imageTable)
            ->where('galleryId', $parent->id)
            ->where('language', $this->language)
            ->count_all_results();
    }


    public function imageInsert($parent, $data = array())
    {
        $order = $this->makeLastOrder($this->imageTable, array('galleryId' => $parent->id));

        $this->db->insert($this->imageTable, array(
            'galleryId' => $parent->id,
            'image' => $data['image']->name,
            'order' => $order,
            'status' => 'published',
            'language' => $this->language,
            'createdAt' => $this->date->set()->mysqlDatetime(),
            'updatedAt' => $this->date->set()->mysqlDatetime()
        ));

        $insertId = $this->db->insert_id();

        if ($insertId > 0) {
            return $this->image($insertId);
        }

        return false;
    }


    public function imageUpdate($record, $data = array())
    {
        $this->db
            ->where('id', $record->id)
            ->update($this->imageTable, array(
                'title' => $this->input->post('title'),
                'image' => $data['image']->name,
                'content' => $this->input->post('content'),
                'status' => $this->input->post('status'),
                'updatedAt' => $this->date->set()->mysqlDatetime()
            ));

        if ($this->db->affected_rows() > 0) {
            return $this->image($record->id);
        }

        return false;
    }


    public function imageDelete($data)
    {
        $records = parent::callDelete($this->imageTable, $data, true);

        if (empty($records)){
            return false;
        }

        foreach ($records as $record){
            $this->utils->deleteFile([
                'public/upload/gallery/images/thumb/'. $record->image,
                'public/upload/gallery/images/medium/'. $record->image,
                'public/upload/gallery/images/wide/'. $record->image,
                'public/upload/gallery/images/normal/'. $record->image
            ]);
        }

        return true;
    }


    public function imageOrder($ids)
    {
        return parent::callOrder($this->imageTable, $ids);
    }

}