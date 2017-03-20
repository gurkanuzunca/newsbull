

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

                    <div class="image">
                        <img src="<?php echo getImage($news->image, 'news/large', 750); ?>" alt="<?php echo htmlspecialchars($news->title); ?>">
                    </div>

                    <div class="news-content common-typography">
                        <?php echo $news->content; ?>
                    </div>

                    <?php $this->view('home/widget/share', ['record' => $news]) ?>

                    <div class="main-news">
                        <h2 class="section-title"><?php echo lang('Benzer Haberler'); ?></h2>
                        <?php if (! empty($similarNews)): ?>
                            <div class="row">
                                <?php $this->view('news/widget/list-two', ['newscast' => $similarNews]) ?>
                            </div>
                        <?php endif ?>
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
