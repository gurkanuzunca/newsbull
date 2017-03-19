<?php

use Controllers\AdminController;

class CategoryAdminController extends AdminController
{
    public $moduleTitle = 'Kategoriler';
    public $module = 'category';
    public $model = 'category';
    public $icon = 'fa-book';
    public $type = 'public';
    public $menuPattern = array(
        'table' => 'categories',
        'title' => 'title',
        'hint' => 'title',
        'link' => array('slug'),
        'language' => true
    );


    // Arama yapılacak kolonlar.
    public $search = array('title');


    public $actions = array(
        'records' => 'list',
        'insert' => 'insert',
        'update' => 'update',
        'delete' => 'delete',
        'order' => 'list',
    );


    public function records()
    {
        parent::callRecords();
        $this->render('records');
    }

    public function insert()
    {
        parent::callInsert();
        $this->render('insert');
    }

    public function update()
    {
        parent::callUpdate();
        $this->render('update');
    }

    public function delete()
    {
        parent::callDelete();
    }

    public function order()
    {
        parent::callOrder();
    }


}