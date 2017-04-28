<?php

use Controllers\AdminController;

class UserAdminController extends AdminController
{
    public $moduleTitle = 'Üyeler';
    public $module = 'user';
    public $model = 'user';
    public $icon = 'fa-user';
    public $type = null;
    public $menuPattern = null;


    // Arama yapılacak kolonlar.
    public $search = array('username', 'name', 'surname', 'email');


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
            $this->image->setDefaultImage($record->avatar);
        }

        $this->image->setMinSizes(300, 300)
            ->addProcess('user/avatar', ['thumbnail' => [300, 300]]);

        $this->modelData['image'] = $this->image->save();
    }

}