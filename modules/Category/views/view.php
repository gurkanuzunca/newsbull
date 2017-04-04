
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="section-title strong"><?php echo $category->title; ?></h1>
                <ul class="breadcrumb">
                    <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a> </li>
                    <li><a href="<?php echo clink([$category->slug]) ?>" title="<?php echo htmlspecialchars($category->title); ?>"><?php echo $category->title; ?></a> </li>
                </ul>
                <div class="category-news">
                    <?php foreach ($category->news as $news): ?>
                        <div class="item">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="image">
                                        <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars($news->title); ?>">
                                            <img src="<?php echo getImage($news->image, 'news/thumb', 480, 300); ?>" alt="<?php echo htmlspecialchars($news->title); ?>">
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
                                        <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars($news->title); ?>">
                                            <h3><?php echo $news->title; ?></h3>
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
