<?php

use Controllers\BaseController;

class NewsController extends BaseController
{
    public $module = 'news';

    public function view($categorySlug, $newsSlug)
    {
        $this->load->model('news/news');

        $news = $this->news->findWithCategory($newsSlug, 'slug');

        if (! $news) {
            show_404();
        }

        $this->news->increaseVisit($news);
        $this->setMeta($news, ['type' => 'article', 'imagePath' => 'news/large']);

        $this->render('news/view', array(
            'news' => $news
        ));
    }




} 