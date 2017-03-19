<?php

use Sirius\Application\Model;

class Search extends Model
{

    public function all($query)
    {
        $this->load->model('news/news');
        $this->load->model('gallery/gallery');
        $results = array();

        if (method_exists($this->news, 'search')) {
            $results['news'] = $this->news->search($query);
        }

        if (method_exists($this->gallery, 'search')) {
            $results['gallery'] = $this->gallery->search($query);
        }

        return $results;
    }
}