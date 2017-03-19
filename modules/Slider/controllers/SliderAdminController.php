<?php

use Controllers\AdminController;

class SliderAdminController extends AdminController
{
    public $moduleTitle = 'Slider';
    public $module = 'slider';
    public $model = 'slider';
    public $icon = 'fa-rocket';
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


    public function validationAfter($action, $record = null)
    {
        if ($action === 'insert') {
            $this->image->required();
        } else {
            $this->image->setDefaultImage($record->image);
        }

        $this->image->setMinSizes(1140, 400)
            ->addProcess('slider', ['thumbnail' => [1140, 400]]);

        $this->modelData['image'] = $this->image->save();
    }

}