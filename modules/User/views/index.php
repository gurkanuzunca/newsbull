<section id="main">
    <div class="container">
        <div class="account">
            <div class="row">
                <div class="col-md-3">
                    <?php $this->view('user/widget/menu') ?>
                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-9">
                            <h1 class="section-title">Yaptığınız yorumlar</h1>

                            <div class="comments">
                                <?php if (! empty($user->comments)): ?>
                                    <?php foreach ($user->comments as $comment): ?>
                                        <div class="comment">
                                            <div class="avatar">
                                                <a href="<?php echo clink(['@news', $comment->news->category->slug, $comment->news->slug]); ?>" title="<?php echo htmlspecialchars(! empty($comment->news->listTitle) ? $comment->news->listTitle : $comment->news->title); ?>">
                                                    <img src="<?php echo getImage($comment->news->image, 'news/thumb', 480, 300); ?>" alt="<?php echo htmlspecialchars(! empty($comment->news->listTitle) ? $comment->news->listTitle : $comment->news->title); ?>">
                                                </a>
                                            </div>
                                            <div class="body">
                                                <div class="username">
                                                    <a href="<?php echo clink(['@news', $comment->news->category->slug, $comment->news->slug]); ?>" title="<?php echo htmlspecialchars(! empty($comment->news->listTitle) ? $comment->news->listTitle : $comment->news->title); ?>">
                                                        <?php echo $comment->news->title; ?>
                                                    </a>
                                                    <span><?php echo $this->date->set()->diff($comment->createdAt)->diffWithDetail(); ?></span>
                                                </div>
                                                <div class="content">
                                                    <?php echo nl2br(htmlspecialchars($comment->content)); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        Henüz yorum yapmamışsınız.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <?php $this->view('user/widget/card') ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
