<?php

use Controllers\BaseController;

/**
 * Class HomeController
 *
 * @property \Slider $slider
 * @property \News $news
 * @property \Category $category
 * @property \Gallery $gallery
 */
class HomeController extends BaseController
{
    public $module = 'home';

    public function index()
    {
        $this->load->model('slider/slider');
        $this->load->model('news/news');
        $this->load->model('category/category');
        $this->load->model('gallery/gallery');

        $sliders = $this->slider->all();

        // Son eklenen 10 haber. Kategorileri ile birlikte.
        $latestNews = $this->news->allWithCategory(['limit' => 10]);

        // Anasayfada gösterilen kategriler.
        $homeCategories = $this->category->showHome(10);

        $homeGalleries = $this->gallery->showHome(6);

        $lastAuthorNews = $this->news->lastAuthorNews();

        $this->render('home/home', array(
            'latestNews' => $latestNews,
            'homeCategories' => $homeCategories,
            'homeGalleries' => $homeGalleries,
            'lastAuthorNews' => $lastAuthorNews,
            'sliders' => $sliders
        ));
    }

}