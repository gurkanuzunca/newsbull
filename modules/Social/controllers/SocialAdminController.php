<?php

use Controllers\AdminController;

class SocialAdminController extends AdminController
{
    public $moduleTitle = 'Sosyal Medya';
    public $module = 'social';
    public $model = 'social';
    public $icon = 'fa-share-alt';
    public $type = null;
    public $menuPattern = null;


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