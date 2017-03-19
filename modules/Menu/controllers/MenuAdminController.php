<?php

use Controllers\AdminController;

class MenuAdminController extends AdminController
{
    public $moduleTitle = 'Menü Yönetimi';
    public $module = 'menu';
    public $model = 'menu';
    public $icon = 'fa-list-ul';


    // Arama yapılacak kolonlar.
    public $search = array('title', 'hint');


    public $actions = array(
        'records' => 'list',
        'insert' => 'insert',
        'update' => 'update',
        'delete' => 'delete',
        'order' => 'list',
        'childs' => 'list',
        'module' => 'insert',
        'groupInsert' => 'list',
        'groupUpdate' => 'list',
        'groupDelete' => 'list',
    );

    /**
     * Menü grupları listeleme
     *
     * @success
     */
    public function records()
    {
        parent::callRecords();
        $this->render('records');
    }

    /**
     * Menü ekleme.
     *
     * @success
     */
    public function insert()
    {
        if ($this->input->post()) {

            $response = array('success' => false, 'html' => 'Kayıt bulunamadı.');
            $parent = $this->appmodel->find($this->uri->segment(4));

            if ($parent) {
                $module = $this->input->post('module');
                $id = $this->input->post('id');

                $data = array(
                    'module' => !empty($module) ? $module : false,
                    'id' => !empty($id) ? $id : false,
                    'title' => $this->input->post('title'),
                    'hint' => $this->input->post('hint'),
                    'link' => $this->input->post('link'),
                );

                $success = $this->appmodel->insert($parent, $data);

                if ($success) {
                    $response['success'] = true;
                }
            }

            $this->json($response);
        }
    }

    /**
     * Menü güncelleme
     *
     * @success
     */
    public function update()
    {
        parent::callUpdate([
            'validation' => 'updateValidation'
        ]);
        $this->render('update');
    }


    public function updateRequest($record)
    {
        $this->setParentsBread($record);
    }

    /**
     * Menü güncelleme validasyonu.
     *
     * @param $action
     * @param $record
     * @success
     */
    public function updateValidation($action, $record = null)
    {
        $this->validate([
            'title' => ['required', 'Lütfen Başlık yazınız.'],
            'hint' => ['required', 'Lütfen Alt Başlık yazınız.'],
            'link' => ['required', 'Lütfen Link yazınız.'],
        ]);

    }

    /**
     * Menü Silme
     *
     * @success
     */
    public function delete()
    {
        parent::callDelete();
    }

    /**
     * Menü sıralama
     *
     * @success
     */
    public function order()
    {
        parent::callOrder();
    }

    /**
     * Menü alt kayıtlar
     */
    public function childs()
    {
        if (! $parent = $this->appmodel->find($this->uri->segment(4))) {
            show_404();
        }

        $this->setParentsBread($parent);

        parent::callRecords([
            'count' => [$this->appmodel, 'childCount', $parent],
            'all' => [$this->appmodel, 'childAll', $parent]
        ]);

        $this->viewData['modules'] = $this->appmodel->moduleAll();
        $this->viewData['parent'] = $parent;
        $this->assets->js('public/admin/js/menu.js', $this->module);
        $this->render('childs');
    }


    private function setParentsBread($record)
    {
        $parents = $this->appmodel->parents($record->id);

        foreach ($parents as $bread){
            $this->utils->breadcrumb($bread['title'], $bread['url']);
        }
    }

    /**
     * Modül listesi
     */
    public function module()
    {
        $response = array('success' => false, 'html' => 'Kayıt bulunamadı.');
        $module = $this->appmodel->module($this->uri->segment(4));

        if ($module) {
            $response['success'] = true;
            $response['html'] = $this->load->view("menu/admin/links", array(
                'records' => $this->appmodel->moduleLinks($module)
            ), true);
        }

        $this->json($response);
    }

    /**
     * Menü grubu validasyonu
     *
     * @param $action
     */
    public function groupValidation($action)
    {
        $this->validate([
            'name' => array('required', 'Lütfen etiket yazınız.'),
            'title' => array('required', 'Lütfen başlık yazınız.'),
        ]);
    }

    /**
     * Menü grubu ekleme
     *
     * @success
     */
    public function groupInsert()
    {
        if (! $this->isRoot()) {
            redirect('home/denied');
        }

        parent::callInsert([
            'insert' => [$this->appmodel, 'groupInsert'],
            'validation' => 'groupValidation',
            'redirect' => ['childs', '@id']
        ]);

        $this->render('group/insert');
    }

    /**
     * Menü grubu düzenleme
     *
     * @success
     */
    public function groupUpdate()
    {
        if (! $this->isRoot()) {
            redirect('home/denied');
        }

        parent::callUpdate([
            'update' => [$this->appmodel, 'groupUpdate'],
            'find' => [$this->appmodel, 'find'],
            'validation' => 'groupValidation',
            'redirect' => ['groupUpdate', '@id']
        ]);

        $this->render('group/update');
    }

    /**
     * Menü grubu silme
     *
     * @success
     */
    public function groupDelete()
    {
        if (! $this->isRoot()) {
            if ($this->input->is_ajax_request()) {
                echo 'home/denied';
            } else {
                redirect('home/denied');
            }
        }

        parent::callDelete([
            'delete' => [$this->appmodel, 'groupDelete']
        ]);

    }
} 