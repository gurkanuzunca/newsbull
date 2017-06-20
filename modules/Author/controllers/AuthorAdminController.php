<?php

use Controllers\AdminController;

class AuthorAdminController extends AdminController
{
    public $moduleTitle = 'Yazarlar';
    public $module = 'author';
    public $model = 'author';
    public $icon = 'fa-user';
    public $type = null;
    public $menuPattern = array(
        'moduleLink' => true
    );


    // Arama yapılacak kolonlar.
    public $search = array('name', 'surname');


    public $actions = array(
        'records' => 'list',
        'insert' => 'insert',
        'update' => 'update',
        'delete' => 'delete'
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

    public function validationAfter($action, $record = null)
    {
        if ($action === 'update') {
            $this->image->setDefaultImage($record->image);
        }

        $this->image->setMinSizes(300, 300)
            ->addProcess('author', ['thumbnail' => [300, 300]]);

        $this->modelData['image'] = $this->image->save();
    }

}