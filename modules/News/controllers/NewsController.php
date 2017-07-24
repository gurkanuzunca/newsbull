<?php

use Controllers\BaseController;

/**
 * Class NewsController
 *
 * @property \News $news
 */
class NewsController extends BaseController
{
    public $module = 'news';

    /**
     * Haber detay
     *
     * @param $categorySlug
     * @param $newsSlug
     */
    public function view($categorySlug, $newsSlug)
    {
        $this->load->model('news/news');

        $news = $this->news->findBySlug($newsSlug, [
            'category' => 'categoryId',
            'author' => 'authorId'
        ]);

        if (! $news) {
            show_404();
        }

        $similarNews = $this->news->similar($news, 4);

        $this->news->increaseVisit($news);
        $this->news->comments($news);

        $this->setMeta($news, ['type' => 'article', 'imagePath' => 'news/large']);

        $this->render('news/view', array(
            'news' => $news,
            'similarNews' => $similarNews
        ));
    }

} 