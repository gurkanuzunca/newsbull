<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="section-title strong"><?php echo $news->title; ?></h1>
                <ul class="breadcrumb">
                    <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a></li>
                    <li><a href="<?php echo clink([$news->category->slug]) ?>" title="<?php echo htmlspecialchars($news->category->title); ?>"><?php echo $news->category->title; ?></a></li>
                    <li><?php echo $this->date->set($news->publishedAt)->datetimeWithName(); ?></li>
                </ul>
                <div class="news-details">
                    <div class="common-summary">
                        <?php echo $news->summary; ?>
                    </div>

                    <?php $this->view('home/widget/share', ['record' => $news]) ?>

                    <?php if ($news->hideImage == 0): ?>
                        <div class="image">
                            <img src="<?php echo getImage($news->image, 'news/large', 750); ?>" alt="<?php echo htmlspecialchars($news->title); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="news-content common-typography">
                        <?php echo $news->content; ?>
                    </div>

                    <?php $this->view('home/widget/share', ['record' => $news]) ?>

                    <?php if (! empty($similarNews)): ?>
                        <div class="main-news">
                            <h2 class="section-title"><?php echo lang('Benzer Haberler'); ?></h2>
                            <div class="row">
                                <?php $this->view('news/widget/list-two', ['newscast' => $similarNews]) ?>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="comments" id="comments">
                        <h2 class="section-title"><?php echo lang('Yorumlar'); ?></h2>
                        <div class="write">
                            <form action="<?php echo clink(['@comment', 'yaz']) ?>" method="post">
                                <input type="hidden" name="news" value="<?php echo $news->id; ?>">
                                <?php echo $this->alert->flash(['error', 'success']); ?>

                                <?php if ($this->auth->logged()): ?>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="form-content">Görüşünüzü yazın</label>
                                                <textarea class="form-control" name="content" id="form-content" required="required" tabindex="1" placeholder="Haber hakkında neder düşünüyorsunuz?"></textarea>
                                            </div>
                                            <button class="btn btn-success" type="submit" tabindex="2">Gönder</button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        Yorum yazabilmek için <a href="<?php echo clink(['@user', 'giris']) ?>" title="Giriş yap">giriş yapın</a>. Henüz kayıt olmadıysanız <a href="<?php echo clink(['@user', 'olustur']) ?>" title="Yeni hesap oluştur">yeni hesap</a> oluşturun.
                                    </div>
                                <?php endif; ?>
                                <?php echo csrfToken(true); ?>
                            </form>
                        </div>

                        <?php if (! empty($news->comments)): ?>
                            <?php foreach ($news->comments as $comment): ?>
                                <div class="comment">
                                    <div class="avatar">
                                        <img src="<?php echo getAvatar($comment->user->avatar); ?>" alt="<?php echo htmlspecialchars($comment->user->username); ?>">

                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            <?php echo $comment->user->username; ?>
                                            <span><?php echo $this->date->set()->diff($comment->createdAt)->diffWithDetail(); ?></span>
                                        </div>
                                        <div class="content">
                                            <?php echo nl2br(htmlspecialchars($comment->content)); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                Henüz yorum yapılmamış. İlk yorumu sen yap!
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <div class="col-sm-4">
                <div class="side-news">
                    <?php $this->view('news/widget/most-visited') ?>
                </div>
            </div>
        </div>
    </div>
</section>
