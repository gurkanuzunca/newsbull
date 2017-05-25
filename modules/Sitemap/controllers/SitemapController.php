<?php

use Controllers\BaseController;

class SitemapController extends BaseController
{
    /**
     * Sitemap dizinleri
     *
     * @return mixed
     */
    public function index()
    {
        $sitemaps = array(
            base_url('sitemap/main.xml'),
            base_url('sitemap/category.xml'),
            base_url('sitemap/news.xml'),
            base_url('sitemap/gallery.xml')
        );

        $this->output->set_content_type('text/xml');
        return $this->load->view('sitemap/index', ['sitemaps' => $sitemaps]);
    }

    /**
     * Sabit sayfalar.
     *
     * @return mixed
     */
    public function main()
    {
        $sitemap = array(
            (object) array(
                'loc'			=> base_url(clink(['@home'])),
                'lastmod'		=> $this->date->set()->format('Y-m-d\TH:i:sP'),
                'changefreq'	=> 'hourly',
                'priority'		=> '1.0'
            ),
            (object) array(
                'loc'			=> base_url(clink(['@gallery'])),
                'lastmod'		=> $this->date->set()->format('Y-m-d\TH:i:sP'),
                'changefreq'	=> 'hourly',
                'priority'		=> '1.0'
            )
        );

        $this->output->set_content_type('text/xml');
        return $this->load->view('sitemap/sitemap', ['sitemap' => $sitemap]);

    }

    /**
     * Kategoriler
     *
     * @return mixed
     */
    public function category()
    {
        $this->load->model('category/category');

        $count = $this->category->count();
        $items = array();
        $sitemap = array();

        if ($count > 0) {
            $paginate = $this->paginate($count, 50000);
            $items = $this->category->all($paginate);
        }

        foreach ($items as $item) {
            $sitemap[] = (object) array(
                'loc'			=> base_url(clink(['@category', $item->slug])),
                'lastmod'		=> $this->date->set($item->updatedAt)->format('Y-m-d\TH:i:sP'),
                'changefreq'	=> 'daily',
                'priority'		=> '0.9'
            );
        }

        $this->output->set_content_type('text/xml');
        return $this->load->view('sitemap/sitemap', ['sitemap' => $sitemap]);

    }

    /**
     * Haberler
     *
     * @return mixed
     */
    public function news()
    {
        $this->load->model('news/news');

        $count = $this->news->count();
        $items = array();
        $sitemap = array();

        if ($count > 0) {
            $paginate = $this->paginate($count, 50000);
            $items = $this->news->allWithCategory($paginate);
        }

        foreach ($items as $item) {
            $sitemap[] = (object) array(
                'loc'			=> base_url(clink(['@news', $item->category->slug, $item->slug])),
                'lastmod'		=> $this->date->set($item->updatedAt)->format('Y-m-d\TH:i:sP'),
                'changefreq'	=> 'weekly',
                'priority'		=> '0.8'
            );
        }

        $this->output->set_content_type('text/xml');
        return $this->load->view('sitemap/sitemap', ['sitemap' => $sitemap]);

    }

    /**
     * Galeriler
     *
     * @return mixed
     */
    public function gallery()
    {
        $this->load->model('gallery/gallery');

        $count = $this->gallery->count();
        $items = array();
        $sitemap = array();

        if ($count > 0) {
            $paginate = $this->paginate($count, 50000);
            $items = $this->gallery->all($paginate);
        }

        foreach ($items as $item) {
            $sitemap[] = (object) array(
                'loc'			=> base_url(clink(['@gallery', $item->slug, $item->slug])),
                'lastmod'		=> $this->date->set($item->updatedAt)->format('Y-m-d\TH:i:sP'),
                'changefreq'	=> 'weekly',
                'priority'		=> '0.8'
            );
        }

        $this->output->set_content_type('text/xml');
        return $this->load->view('sitemap/sitemap', ['sitemap' => $sitemap]);
    }

} 