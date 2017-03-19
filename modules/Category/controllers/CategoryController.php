<?php

use Controllers\BaseController;

class CategoryController extends BaseController
{
    public $module = 'category';

    public function view($categorySlug)
    {
        $this->load->model('category/category');

        $category = $this->category->findWithNews($categorySlug, 'slug');

        if (! $category) {
            show_404();
        }

        $this->render('category/view', array(
            'category' => $category
        ));
    }



} 