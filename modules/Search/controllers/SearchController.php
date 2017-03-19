<?php

use Controllers\BaseController;

class SearchController extends BaseController
{
    public $module = 'search';

    public function search()
    {
        $query = $this->input->get('q');
        $results = array();

        if (strlen($query) > 0) {
            $this->load->model('search/search');

            $results = $this->search->all($query);
        }

        $this->render('search/search', array(
            'results' => $results
        ));
    }




} 