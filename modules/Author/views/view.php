
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="section-title strong"><?php echo $author->fullname; ?></h1>
                <ul class="breadcrumb">
                    <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a> </li>
                    <li><a href="<?php echo clink(['@author']) ?>" title="<?php echo $this->module->arguments->title; ?>"><?php echo $this->module->arguments->title; ?></a> </li>
                    <li><a href="<?php echo clink(['@author', $author->slug]) ?>" title="<?php echo htmlspecialchars($author->fullname); ?>"><?php echo $author->fullname; ?></a> </li>
                </ul>

                <div class="author-card">
                    <div class="row">
                        <div class="column col-sm-2">
                            <div class="image">
                                <img src="<?php echo getImage($author->image, 'author', 300, 300); ?>" alt="<?php echo htmlspecialchars($author->fullname); ?>">
                            </div>
                        </div>
                        <div class="column col-sm-9">
                            <div class="detail">
                                <h3><?php echo lang('Yazar Hakkında') ?></h3>
                                <p class="about"><?php echo $author->about; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->view('home/widget/share', ['record' => $author, 'title' => $author->fullname]) ?>

                <div class="category-news">
                    <?php foreach ($author->news as $news): ?>
                        <div class="item">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="image">
                                        <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars(! empty($news->listTitle) ? $news->listTitle : $news->title); ?>">
                                            <img src="<?php echo getImage($news->image, 'news/thumb', 480, 300); ?>" alt="<?php echo htmlspecialchars(! empty($news->listTitle) ? $news->listTitle : $news->title); ?>">
                                        </a>
                                        <?php if (isset($news->category)): ?>
                                            <div class="category">
                                                <a href="<?php echo clink([$news->category->slug]); ?>" title="<?php echo htmlspecialchars($news->category->title); ?>"><?php echo $news->category->title; ?></a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars(! empty($news->listTitle) ? $news->listTitle : $news->title); ?>">
                                            <h3><?php echo ! empty($news->listTitle) ? $news->listTitle : $news->title; ?></h3>
                                            <p><?php echo $news->summary; ?></p>
                                            <div class="date">
                                                <i class="fa fa-clock-o"></i> <?php echo makeDate($news->publishedAt)->dateWithName(); ?>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (! empty($paginate)): ?>
                    <?php echo $paginate['pagination'] ?>
                <?php endif; ?>
            </div>

            <div class="col-sm-4">
                <div class="side-news">
                    <?php $this->view('news/widget/most-visited') ?>
                </div>
            </div>
        </div>
    </div>
</section>
