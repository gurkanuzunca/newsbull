<?php

use Models\AdminModel;

class NewsAdmin extends AdminModel
{
    protected $table = 'news';


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
            ->select("{$this->table}.*, categories.slug categorySlug, (SELECT COUNT(id) FROM comments WHERE comments.newsId = {$this->table}.id) comments")
            ->from($this->table)
            ->join('categories', "categories.id = {$this->table}.categoryId")
            ->where("{$this->table}.language", $this->language)
            ->order_by("{$this->table}.id", 'desc')
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
        $publishedAt = $this->input->post('publishedAt');
        $authorId = $this->input->post('authorId');

        $this->db->insert($this->table, array(
            'categoryId' => $this->input->post('categoryId'),
            'authorId' => ! empty($authorId) ? $authorId : null,
            'title' => $this->input->post('title'),
            'listTitle' => $this->input->post('listTitle'),
            'slug' => $this->makeSlug(),
            'summary' => $this->input->post('summary'),
            'image' => $data['image']->name,
            'hideImage' => $this->input->post('hideImage'),
            'content' => $this->input->post('content'),
            'metaTitle' => $this->input->post('metaTitle'),
            'metaDescription' => $this->input->post('metaDescription'),
            'metaKeywords' => $this->input->post('metaKeywords'),
            'status' => $this->input->post('status'),
            'language' => $this->language,
            'publishedAt' => empty($publishedAt) ? $this->date->set()->mysqlDatetime() : $publishedAt,
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
        $publishedAt = $this->input->post('publishedAt');
        $authorId = $this->input->post('authorId');

        $this->db
            ->where('id', $record->id)
            ->update($this->table, array(
                'categoryId' => $this->input->post('categoryId'),
                'authorId' => ! empty($authorId) ? $authorId : null,
                'title' => $this->input->post('title'),
                'listTitle' => $this->input->post('listTitle'),
                'slug' => $this->makeSlug(),
                'summary' => $this->input->post('summary'),
                'image' => $data['image']->name,
                'hideImage' => $this->input->post('hideImage'),
                'content' => $this->input->post('content'),
                'metaTitle' => $this->input->post('metaTitle'),
                'metaDescription' => $this->input->post('metaDescription'),
                'metaKeywords' => $this->input->post('metaKeywords'),
                'status' => $this->input->post('status'),
                'publishedAt' => empty($publishedAt) ? $this->date->set()->mysqlDatetime() : $publishedAt,
                'updatedAt' => $this->date->set()->mysqlDatetime(),
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
                'public/upload/news/large/'. $record->image,
                'public/upload/news/showcase/'. $record->image,
                'public/upload/news/thumb/'. $record->image
            ]);
        }

        return true;
    }


    public function categories()
    {
        return $this->db
            ->from('categories')
            ->where('language', $this->language)
            ->order_by("order", 'asc')
            ->order_by("id", 'asc')
            ->get()
            ->result();
    }

    public function authors()
    {
        return $this->db
            ->select("authors.*, authors.fullname")
            ->from('authors')
            ->order_by("id", 'asc')
            ->get()
            ->result();
    }

}