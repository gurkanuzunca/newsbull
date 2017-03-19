<?php

use Controllers\BaseController;

class GalleryController extends BaseController
{
    public $module = 'gallery';


    public function index()
    {
        $this->load->model('gallery/gallery');

        $galleries = array();
        $paginate = null;
        $count = $this->gallery->count();

        if ($count > 0) {
            $paginate = $this->paginate($count);
            $galleries = $this->gallery->all($paginate);
        }

        $this->render('gallery/index', array(
            'galleries' => $galleries,
            'paginate' => $paginate
        ));
    }


    public function view($gallerySlug)
    {
        $this->load->model('gallery/gallery');
        $imageIndex = (int) $this->input->get('resim');
        $imageNext = 1;
        $gallery = $this->gallery->findWithImages($gallerySlug, 'slug');
        $image = null;
        $increaseOnce = false;

        if (! $gallery) {
            show_404();
        }

        // Detay tasarımı Sayfalı ise query string'e göre işlem yapılır.
        // $imageIndex yoksa, 1'den küçükse ve toplam resimden büyükse 0 index olarak tanımlanır.
        // Diğer durumda insex ($imageIndex - 1)'dir
        if ($gallery->design === 'paging') {
            $imageIndex = $imageIndex <= 1 ? $imageIndex = 0 : $imageIndex - 1;

            if (isset($gallery->images[$imageIndex])) {
                $image = $gallery->images[$imageIndex];
                $imageNext = $imageIndex + 1;
            } else {
                $image = $gallery->images[0];
            }

            $imageNext++;

            if (! isset($gallery->images[$imageNext])) {
                $imageNext = 1;
            }

            // Gösterim sayısı 1 kere arttırılacak.
            $increaseOnce = true;

            if ($imageIndex === 0) {
                $increaseOnce = false;
            }

        }

        $this->gallery->increaseVisit($gallery, $increaseOnce);
        $this->setMeta($gallery, ['type' => 'article', 'imagePath' => 'gallery']);

        $this->render('gallery/view', array(
            'gallery' => $gallery,
            'image' => $image,
            'imageNext' => $imageNext
        ));
    }



} 