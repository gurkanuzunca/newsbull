<?php

namespace Sirius\Admin;


abstract class Actuator extends Controller
{
    public $definitions;
    public $table;
    public $columns = array();
    public $orders = array();
    public $groupsToPositions = array();
    public $groups = array(
        'default' => array(
            'title' => 'Genel',
            'position' => 'left'
        ),
        'publish' => array(
            'title' => 'Yayımla',
            'position' => 'right'
        ),
        'meta' => array(
            'title' => 'Meta Bilgileri',
            'position' => 'right'
        )
    );

    public $positions = array(
        'left' => 'col-sm-8',
        'right' => 'col-sm-4'
    );


    public $parent = false;

    private $defaults = array(
        'publish' => array(
            'status' => array(
                'label' => 'Durum',
                'type' => 'dropdown',
                'insert' => true,
                'update' => true,
                'show' => array(
                    'list' => true,
                    'insert' => true,
                    'update' => true
                ),
                'options' => ['published' => 'Yayında', 'unpublished' => 'Yayında Değil'],
                'default' => 'published',
                'styles' => [
                    'published' => '<span class="label label-success">Yayında</span>',
                    'unpublished' => '<span class="label label-danger">Yayında Değil</span>'
                ],
                'width' => '150'
            ),
            'createdAt' => array(
                'label' => 'Oluşturulma Tarihi',
                'type' => 'datetime',
                'insert' => true,
                'show' => array(
                    'update' => true
                ),
                'group' => 'publish',
                'default' => 'now',
                'disabled' => true
            ),
            'updatedAt' => array(
                'label' => 'Güncellenme Tarihi',
                'type' => 'datetime',
                'update' => true,
                'show' => array(
                    'update' => true
                ),
                'group' => 'publish',
                'default' => 'now',
                'disabled' => true
            )
        ),
        'meta' => array(
            'metaTitle' => array(
                'label' => 'Title',
                'type' => 'text',
                'insert' => true,
                'update' => true,
                'show' => array(
                    'insert' => true,
                    'update' => true
                )

            ),
            'metaDescription' => array(
                'label' => 'Description',
                'type' => 'textarea',
                'insert' => true,
                'update' => true,
                'show' => array(
                    'insert' => true,
                    'update' => true
                )
            ),
            'metaKeywords' => array(
                'label' => 'Keywords',
                'type' => 'textarea',
                'insert' => true,
                'update' => true,
                'show' => array(
                    'insert' => true,
                    'update' => true
                )
            )
        )
    );

    public $images = false;
    public $imageOrders = array();
    public $imageColumns = array(
        'image' => array(
            'label' => 'Görsel',
            'type' => 'image',
            'insert' => true,
            'update' => true,
            'show' => array(
                'list' => true,
                'insert' => true,
                'update' => true
            ),
            'size' => array(480, 360),
            'process' => array(
                'news/images/thumb' => ['thumbnail' => [480, 360]],
                'news/images/normal' => ['best_fit' => [900, 900]]
            ),
            'required' => true
        ),
        'order' => array(
            'label' => 'Sıra',
            'type' => 'order',
            'insert' => true,
            'show' => array(
                'list' => true
            ),
            'sort' => 'asc'
        )
    );


    public function __construct()
    {
        if (empty($this->table)) {
            throw new \Exception('Actuator table tanimlanmamis.');
        }

        if (empty($this->definitions['columns'])) {
            throw new \Exception('Actuator columns tanimlanmamis.');
        }

        $this->model = 'Actuator';


        if (isset($this->definitions['groups'])) {
            $this->groups = array_merge($this->groups, $this->definitions['groups']);
        }

        if (isset($this->definitions['positions'])) {
            $this->positions = array_merge($this->positions, $this->definitions['positions']);
        }

        foreach ($this->groups as $group => $options) {
            if (! isset($this->groupsToPositions[$options['position']])) {
                $this->groupsToPositions[$options['position']] = array();
            }

            $this->groupsToPositions[$options['position']][] = $group;
        }


        if (isset($this->definitions['columns']['meta'])) {
            if ($this->definitions['columns']['meta'] === true) {
                $this->definitions['columns']['meta'] = $this->defaults['meta'];
            } else {
                $this->definitions['columns']['meta'] = array_merge($this->defaults['meta'], $this->definitions['columns']['meta']);
            }
        }


        if (isset($this->definitions['columns']['publish'])) {
            if ($this->definitions['columns']['publish'] === true) {
                $this->definitions['columns']['publish'] = $this->defaults['publish'];
            } else {
                $this->definitions['columns']['publish'] = array_merge($this->defaults['publish'], $this->definitions['columns']['publish']);
            }
        }

        foreach ($this->definitions['columns'] as $group) {
            $this->columns = array_merge($this->columns, $group);
        }

        foreach ($this->columns as $column => $options) {
            if ($options['type'] === 'order') {
                if (! isset($options['sort'])) {
                    throw new \Exception($column. 'alanı siralama yonu tanimlanmamis.');
                }

                $this->orders[$column] = $options['sort'];
            }
        }

        $this->orders['id'] = 'asc';


        if ($this->images === true) {
            foreach ($this->imageColumns as $column => $options) {
                if ($options['type'] === 'order') {
                    if (! isset($options['sort'])) {
                        throw new \Exception($column. 'alanı siralama yonu tanimlanmamis.');
                    }

                    $this->imageOrders[$column] = $options['sort'];
                }
            }
        }


        parent::__construct();
    }

    public function records()
    {
        if ($this->parent === true) {
            /**
             * Eğer parent verilmişse breadcrump hazırlanır.
             * Parent değeri view'a atanır.
             */
            if ($this->uri->segment(4) > 0) {
                if (! $parent = $this->appmodel->find($this->uri->segment(4))) {
                    show_404();
                }

                $this->setParentsBread($parent);
                $this->viewData['parent'] = $parent;
            }
        }

        parent::callRecords([
            'count' => [$this->appmodel, 'count', isset($parent) ? $parent : null],
            'all' => [$this->appmodel, 'all', isset($parent) ? $parent : null]
        ]);
        $this->render('records', true);
    }


    public function insert()
    {
        if ($this->parent === true) {
            /**
             * Eğer parent verilmişse breadcrump hazırlanır.
             * Parent değeri view'a atanır.
             */
            if ($this->uri->segment(4) > 0) {
                if (!$parent = $this->appmodel->find($this->uri->segment(4))) {
                    show_404();
                }

                $this->setParentsBread($parent);
                $this->viewData['parent'] = $parent;
            }
        }

        parent::callInsert([
            'insert' => [$this->appmodel, 'insert', isset($parent) ? $parent : null],
        ]);

        $this->assets->importEditor();
        $this->render('insert', true);
    }

    public function update()
    {
        if ($this->parent === true) {
            /**
             * Eğer parent verilmişse breadcrump hazırlanır.
             * Parent değeri view'a atanır.
             */
            if ($this->uri->segment(4) > 0) {
                if (!$parent = $this->appmodel->find($this->uri->segment(4))) {
                    show_404();
                }

                $this->setParentsBread($parent);
                $this->viewData['parent'] = $parent;
            }
        }

        parent::callUpdate();
        $this->assets->importEditor();
        $this->render('update', true);
    }

    public function delete()
    {
        parent::callDelete();
    }

    public function order()
    {
        parent::callOrder();
    }


    public function validation($action, $record = null)
    {
        $rules = [];

        foreach ($this->columns as $column => $options) {
            if (isset($options['validation'])) {
                if (isset($options['validation'][$action])) {
                    $rules[$column] = $options['validation'][$action];
                } else {
                    $rules[$column] = $options['validation'];
                }
            }

        }
        $this->validate($rules);
    }


    public function validationAfter($action, $record = null)
    {
        foreach ($this->columns as $column => $options) {
            if ($options['type'] === 'image') {
                if ($action === 'insert' && isset($options['required']) && $options['required'] === true) {
                    $this->image->required();
                } else {
                    $this->image->setDefaultImage($record->image);
                }

                if (isset($options['size'])) {
                    if (! is_array($options['size']) || (is_array($options['size']) && count($options['size']) === 1)) {
                        $options['size'] = array((int) $options['size']);
                    }

                    if (count($options['size']) === 1) {
                        $options['size'] = array($options['size'], 0);
                    }

                    $this->image->setMinSizes($options['size'][0], $options['size'][1]);

                }

                foreach ($options['process'] as $path => $opt) {
                    $this->image->addProcess($path, $opt);
                }


                $this->modelData['files'][$column] = $this->image->save();
            }
        }
    }


    private function setParentsBread($record)
    {
        $parents = $this->appmodel->parents($record->id);

        foreach ($parents as $bread){
            $this->utils->breadcrumb($bread['title'], $bread['url']);
        }
    }


    public function images()
    {
        if (! $parent = $this->appmodel->find($this->uri->segment(4))) {
            show_404();
        }

        $this->utils->breadcrumb("{$parent->title}: Resimler", moduleUri('images', $parent->id));

        parent::callRecords(array(
            'count' => [$this->appmodel, 'imageCount', $parent],
            'all' => [$this->appmodel, 'imageAll', $parent]
        ));

        $this->viewData['parent'] = $parent;
        $this->assets->importPlupload();
        $this->render('images/records', true);
    }


    public function imageInsert()
    {
        if (! $parent = $this->appmodel->find($this->uri->segment(4))) {
            $this->json(array(
                'jsonrpc'   => '2.0',
                'error'     => array('code' => '500', 'message' => 'Kayıt bulunamadı.'),
                'id'        => 'id'
            ));
        }

        foreach ($this->imageColumns as $column => $options) {
            if ($options['type'] === 'image') {
                $this->image->required()->usePlupload()->setUploadInput('file');

                if (isset($options['size'])) {
                    if (! is_array($options['size']) || (is_array($options['size']) && count($options['size']) === 1)) {
                        $options['size'] = array((int) $options['size']);
                    }

                    if (count($options['size']) === 1) {
                        $options['size'] = array($options['size'], 0);
                    }

                    $this->image->setMinSizes($options['size'][0], $options['size'][1]);

                }

                foreach ($options['process'] as $path => $opt) {
                    $this->image->addProcess($path, $opt);
                }

                if ($image = $this->image->save()) {
                    $this->modelData['files'][$column] = $image;
                } else {
                    return false;
                }

            }
        }

        $success = $this->appmodel->imageInsert($parent, $this->modelData);

        if ($success) {
            $this->json(array(
                'jsonrpc'   => '2.0',
                'error'     => array(),
                'id'        => 'id'
            ));
        }
    }


    public function imageUpdate()
    {
        if (! $record = $this->appmodel->image($this->uri->segment(4))) {
            show_404();
        }

        $parent = $this->appmodel->find($record->parentId);

        $this->utils->breadcrumb("{$parent->title}: Resimler", moduleUri('images', $parent->id));

        parent::callUpdate([
            'update' => [$this->appmodel, 'imageUpdate'],
            'find' => [$this->appmodel, 'image'],
            'redirect' => ['imageUpdate', '@id']
        ]);

        $this->viewData['parent'] = $parent;
        $this->render('images/update', true);
    }



    public function imageDelete()
    {
        parent::callDelete([
            'delete' => [$this->appmodel, 'imageDelete'],
            'find' => [$this->appmodel, 'image'],
        ]);
    }


    /**
     * Sıralama işlemi yapar
     */
    public function imageOrder()
    {
        parent::callOrder([
            'order' => [$this->appmodel, 'imageOrder']
        ]);
    }


    public function createForm($type, $columns, $record = null)
    {
        $response = '';

        foreach ($columns as $column => $options) {
            if (isset($options['show'][$type]) && $options['show'][$type] === true) {
                $required = isset($options['required']) ? $options['required'] : false;
                $disabled = isset($options['disabled']) ? $options['disabled'] : false;
                $value = null;
                if ($type === 'update' && ! is_null($record)) {
                    $value = $record->$column;
                }

                switch ($options['type']) {
                    case 'textarea': {
                        $response .= bsFormTextarea($column, $options['label'], [
                            'value' => $value,
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                        break;
                    }
                    case 'dropdown': {
                        $response .= bsFormDropdown($column, $options['label'], [
                            'options' => $options['options'],
                            'value' => $value,
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                        break;
                    }
                    case 'editor': {
                        $response .= bsFormEditor($column, $options['label'], [
                            'value' => $value,
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                        break;
                    }
                    case 'image': {
                        $response .= bsFormImage($column, $options['label'], [
                            'value' => $value,
                            'path' => 'public/upload/'.array_keys($options['process'])[0],
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                        break;
                    }
                    case 'datetime': {
                        $response .= bsFormDatetime($column, $options['label'], [
                            'value' => $value ? $this->date->set($value)->datetimeWithName() : $value,
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                        break;
                    }
                    default: {
                        $response .= bsFormText($column, $options['label'], [
                            'value' => $value,
                            'disabled' => $disabled,
                            'required' => $required
                        ]);
                    }
                }
            }
        }

        return $response;
    }

}