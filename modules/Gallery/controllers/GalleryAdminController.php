<?php

use Controllers\AdminController;

class GalleryAdminController extends AdminController
{
    public $moduleTitle = 'Galeriler';
    public $module = 'gallery';
    public $model = 'gallery';
    public $icon = 'fa-picture-o';
    public $type = 'public';
    public $menuPattern = array(
        'table' => 'galleries',
        'title' => 'title',
        'hint' => 'title',
        'link' => array('slug'),
        'language' => true,
        'moduleLink' => true
    );


    // Arama yapılacak kolonlar.
    public $search = array('title');


    public $actions = array(
        'records' => 'list',
        'insert' => 'insert',
        'update' => 'update',
        'delete' => 'delete',
        'order' => 'list',
        'images' => 'image-list',
        'imageInsert' => 'image-insert',
        'imageUpdate' => 'image-update',
        'imageDelete' => 'image-delete',
        'imageOrder' => 'image-list',
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

        $this->image->setMinSizes(480, 300)
            ->addProcess('gallery', ['thumbnail' => [480, 300]]);

        $this->modelData['image'] = $this->image->save();
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
        $this->render('images/records');
    }


    public function imageInsert()
    {
        $success = false;

        if (! $parent = $this->appmodel->find($this->uri->segment(4))) {
            $this->json(array(
                'jsonrpc'   => '2.0',
                'error'     => array('code' => '500', 'message' => 'Kayıt bulunamadı.'),
                'id'        => 'id'
            ));
        }

        $this->image
            ->required()
            ->usePlupload()
            ->setUploadInput('file')
            ->setMinSizes(750, 470)
            ->addProcess('gallery/images/thumb', ['thumbnail' => [480, 300]])
            ->addProcess('gallery/images/medium', ['thumbnail' => [750, 470]])
            ->addProcess('gallery/images/wide', ['fit_to_width' => [750]])
            ->addProcess('gallery/images/normal', ['best_fit' => [1200, 1200]]);

        $this->modelData['image'] = $this->image->save();

        if ($this->modelData['image'] !== false) {
            $success = $this->appmodel->imageInsert($parent, $this->modelData);
        }

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

        $parent = $this->appmodel->find($record->galleryId);

        $this->utils->breadcrumb("{$parent->title}: Resimler", moduleUri('images', $parent->id));

        parent::callUpdate([
            'update' => [$this->appmodel, 'imageUpdate'],
            'find' => [$this->appmodel, 'image'],
            'redirect' => ['imageUpdate', '@id']
        ]);

        $this->assets->importEditor();
        $this->viewData['parent'] = $parent;
        $this->render('images/update');
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


}