<?php

use Controllers\BaseController;

class CategoryController extends BaseController
{
    public $module = 'category';

    public function view($categorySlug)
    {
        $this->load->model('category/category');
        $this->load->model('news/news');

        $category = $this->category->findBySlug($categorySlug);
        $paginate = null;

        if (! $category) {
            show_404();
        }

        $this->category->newsCount($category);
        $category->news = array();

        if ($category->newsCount > 0) {
            $paginate = $this->paginate($category->newsCount, 10);
            $this->category->news($category, $paginate);
        }

        $this->render('category/view', array(
            'category' => $category,
            'paginate' => $paginate
        ));
    }



} 