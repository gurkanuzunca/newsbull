<?php

use Controllers\BaseController;

/**
 * Class CommentController
 *
 * @property \Auth $auth
 * @property \Comment $comment
 * @property \News $news
 */
class CommentController extends BaseController
{
    public $module = 'comment';

    public function create()
    {
        if (! $this->auth->logged()) {
            redirect(clink(['@user', 'giris']));
        }

        if ($this->input->post()) {
            $this->load->model('comment/comment');
            $this->load->model('news/news');
            $news = false;

            $this->validate([
                'news' => array('required', 'İlgili haber bulunamadı.'),
                'content' => array('required|min_length[6]', 'Yorumunuz çok kısa.')
            ]);

            if (! $this->alert->has('error')) {
                $news = $this->news->find($this->input->post('news'));

                if (! $news) {
                    $this->alert->set('error', 'İlgili haber bulunamadı.');
                }
            }

            if (! $this->alert->has('error')) {
                $success = $this->comment->create($this->getUser(), $news);

                if ($success) {
                    $this->alert->set('success', 'Yorumunuz başarıyla kaydedildi. Onay aldıktan sonra yayına alınacaktır.');
                    redirect($this->input->server('HTTP_REFERER').'#comments');
                }

                $this->alert->set('error', 'Hata oluştu. Lütfen tekrar deneyiniz.');
            }

            redirect($this->input->server('HTTP_REFERER').'#comments');
        }
    }




} 