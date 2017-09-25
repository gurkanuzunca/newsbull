<?php

use Models\BaseModel;

/**
 * Class News
 *
 * @property \Comment $comment
 * @property \Category $category
 * @property \Author $author
 */
class News extends BaseModel
{
    private $table = 'news';

    /**
     * Kayıt bulma
     *
     * @param $value
     * @param string $column
     * @return object
     */
    public function find($value, $column = 'id')
    {
        return $this->db
            ->from($this->table)
            ->where($column, $value)
            ->where('status', 'published')
            ->where('publishedAt <', $this->date->set()->mysqlDatetime())
            ->where('language', $this->language)
            ->get()
            ->row();
    }


    /**
     * Kayıtları bulma
     *
     * @param array $values
     * @param string $column
     * @return array
     */
    public function findIn(array $values, $column = 'id')
    {
        $values = array_unique($values);

        return $this->db
            ->from($this->table)
            ->where_in($column, $values)
            ->where('status', 'published')
            ->where('publishedAt <', $this->date->set()->mysqlDatetime())
            ->where('language', $this->language)
            ->get()
            ->result();
    }

    /**
     * Slug'a göre kaydı bulur.
     *
     * @param string $slug
     * @param array $with
     * @return object
     */
    public function findBySlug($slug, $with = array())
    {
        $news = $this->find($slug, 'slug');

        if ($news && ! empty($with)) {
            foreach ($with as $model => $column) {
                $this->load->model("{$model}/{$model}");
                $news->$model = $this->$model->find($news->$column);
            }
        }

        return $news;
    }

    /**
     * Haberin yorumlarını döndürür.
     *
     * @param object $news
     * @param array $paginate
     *
     * @return void
     */
    public function comments($news, $paginate = [])
    {
        $this->load->model('comment/comment');
        $this->db->where('newsId', $news->id);
        $news->comments = $this->comment->allWithUser($paginate);
    }

    /**
     * Haberin yorum sayısını göndürür.
     *
     * @param $news
     */
    public function commentCount($news)
    {
        $this->load->model('comment/comment');
        $this->db->where('newsId', $news->id);
        $news->commentCount = $this->comment->count();
    }

    /**
     * Tüm kayıtları döndürür.
     *
     * @param array $paginate
     * @return array
     */
    public function all($paginate = [])
    {
        $this->setPaginate($paginate);

        return $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->where('publishedAt <', $this->date->set()->mysqlDatetime())
            ->where('language', $this->language)
            ->order_by('publishedAt', 'desc')
            ->get()
            ->result();
    }

    /**
     * Tüm kayıtları kategorileri ile birlikte döndürür.
     *
     * @param array $paginate
     * @return array
     */
    public function allWithCategory($paginate = [])
    {
        $news = $this->all($paginate);

        if ($news) {
            $this->load->model('category/category');

            $categoryIds = $this->getColumnData($news, 'categoryId');
            $categories = $this->category->findIn($categoryIds);
            $this->setRelationOne('category', $news, 'categoryId', $categories, 'id');
        }

        return $news;
    }


    /**
     * Toplam kayıt sayısı.
     *
     * @return int
     */
    public function count()
    {
        return $this->db
            ->from($this->table)
            ->where('status', 'published')
            ->where('publishedAt <', $this->date->set()->mysqlDatetime())
            ->where('language', $this->language)
            ->count_all_results();
    }



    public function mostVisited($limit)
    {
        $this->db->order_by('visited', 'desc');
        return $this->allWithCategory(['limit' => $limit]);
    }


    public function increaseVisit($record, $session = false)
    {
        $visitedNews = $session === true ? $this->session->userdata('visitedNews') : array();

        if (! is_array($visitedNews)) {
            $visitedNews = array();
        }

        if (! in_array($record->id, $visitedNews)) {
            $this->db
                ->where('id', $record->id)
                ->update($this->table, array(
                    'visited' => $record->visited + 1
                ));

            if ($this->db->affected_rows() > 0) {
                $record->visited = $record->visited +1;
                $visitedNews[] = $record->id;

                if ($session === true) {
                    $this->session->set_userdata('visitedNews', $visitedNews);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * Referans alınan haber ile aynı kategorideki benzer haberler.
     *
     * @param \StdClass $news Referans alınan haber
     * @param int $limit
     * @return array
     */
    public function similar($news, $limit)
    {
        $this->db->where('id !=', $news->id)
            ->where('categoryId', $news->categoryId);

        return $this->allWithCategory(['limit' => $limit]);
    }

    /**
     * @param $query
     * @return array
     */
    public function search($query)
    {
        $this->db->like('title', $query)->or_like('summary', $query);
        return $this->allWithCategory();
    }

    public function lastAuthorNews()
    {
        /**
         * Group by için sql mode değiştiriliyor.
         * Mysql 5.7'den itibaren ONLY_FULL_GROUP_BY aktif gelmekte
         * bu sebeple group by ile bağlı olmayan kolonlar döndürülmüyor.
         *
         * Eğer mod aktifse bu oturum için pasif edilip tekrar aktif ediliyor.
         * @see https://dev.mysql.com/doc/refman/5.7/en/sql-mode.html#sqlmode_only_full_group_by
         *
         * **
         * Sql mod algılama ve group by modu pasif etme.
         */
        $sqlMode = $this->db->query("SELECT @@SESSION.sql_mode AS modes")->row();
        $sqlMode->modes = explode(',', $sqlMode->modes);
        $groupByKey = array_search('ONLY_FULL_GROUP_BY', $sqlMode->modes);

        if ($groupByKey !== false) {
            unset($sqlMode->modes[$groupByKey]);
            $this->db->query("SET SESSION sql_mode='".(implode(',', $sqlMode->modes))."'");
        }
        /** *****/

        $subQuery = sprintf("SELECT * FROM news WHERE authorId IS NOT NULL AND status = 'published' AND publishedAt < '%s' AND language = '%s' ORDER BY publishedAt DESC", $this->date->set()->mysqlDatetime(), $this->language);
        $news = $this->db->query("SELECT latest.* FROM ({$subQuery}) latest GROUP BY latest.authorId ORDER BY latest.publishedAt DESC LIMIT 4")->result();

        /**
         * Sql modu eski ayarlarına geri alma.
         */
        if ($groupByKey !== false) {
            $sqlMode->modes[] = 'ONLY_FULL_GROUP_BY';
            $this->db->query("SET SESSION sql_mode='" . (implode(',', $sqlMode->modes)) . "'");
        }
        /** *****/

        if ($news) {
            $this->load->model('category/category');

            $categoryIds = $this->getColumnData($news, 'categoryId');
            $categories = $this->category->findIn($categoryIds);
            $this->setRelationOne('category', $news, 'categoryId', $categories, 'id');

            $this->load->model('author/author');

            $authorIds = $this->getColumnData($news, 'authorId');
            $authors = $this->author->findIn($authorIds);
            $this->setRelationOne('author', $news, 'authorId', $authors, 'id');
        }

        return $news;
    }
}