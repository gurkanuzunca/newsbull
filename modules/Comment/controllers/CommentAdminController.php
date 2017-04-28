<?php

use Controllers\AdminController;

class CommentAdminController extends AdminController
{
    public $moduleTitle = 'Yorumlar';
    public $module = 'comment';
    public $model = 'comment';
    public $icon = 'fa-newspaper-o';
    public $type = null;
    public $menuPattern = null;


    public $actions = array(
        'records' => 'list',
        'update' => 'update',
        'delete' => 'delete'
    );


    public function records()
    {
        parent::callRecords();
        $this->render('records');
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

}