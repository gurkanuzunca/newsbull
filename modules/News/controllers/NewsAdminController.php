<?php

use Controllers\AdminController;

class NewsAdminController extends AdminController
{
    public $moduleTitle = 'Haberler';
    public $module = 'news';
    public $model = 'news';
    public $icon = 'fa-newspaper-o';
    public $type = null;
    public $menuPattern = null;


    // Arama yapılacak kolonlar.
    public $search = array('title');
    public $filter = array('authorId');


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
        $this->assets->importEditor();
        $this->render('insert');
    }

    public function update()
    {
        parent::callUpdate();
        $this->assets->importEditor();
        $this->render('update');
    }

    public function delete()
    {
        parent::callDelete();
    }

    public function validationAfter($action, $record = null)
    {
        if ($action === 'insert') {
            $this->image->required();
        } else {
            $this->image->setDefaultImage($record->image);
        }

        $this->image->setMinSizes(750, 370)
            ->addProcess('news/thumb', ['thumbnail' => [480, 300]])
            ->addProcess('news/showcase', ['thumbnail' => [480, 370]])
            ->addProcess('news/large', ['fit_to_width' => [750]]);

        $this->modelData['image'] = $this->image->save();
    }

}