<?php

use Controllers\BaseController;

/**
 * Class AuthorController
 *
 * @property Author $author
 */
class AuthorController extends BaseController
{
    public $module = 'author';

    /**
     * Yazarlar listesi.
     */
    public function index()
    {
        $this->load->model('author/author');

        $authors = array();
        $paginate = null;
        $count = $this->author->count();

        if ($count > 0) {
            $paginate = $this->paginate($count);
            $authors = $this->author->all($paginate);
        }

        $this->render('author/index', array(
            'authors' => $authors,
            'paginate' => $paginate
        ));
    }

    /**
     * Yazar detay sayfası
     *
     * @param string $authorSlug
     */
    public function view($authorSlug)
    {
        $this->load->model('author/author');

        $author = $this->author->find($authorSlug, 'slug');

        if (! $author) {
            show_404();
        }

        $this->author->news($author);

        $this->render('author/view', array(
            'author' => $author,
        ));
    }


} 