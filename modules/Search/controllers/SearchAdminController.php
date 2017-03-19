<?php

use Controllers\AdminController;

class SearchAdminController extends AdminController
{
    public $moduleTitle = 'Arama';
    public $module = 'search';
    public $model = 'search';
    public $icon = 'fa-search';
    public $type = null;
    public $menuPattern = null;

    public $actions = array(
        'records' => 'list'
    );

    public function records()
    {
        $this->render('records');
    }
}