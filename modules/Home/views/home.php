
<?php $this->view('slider/slider') ?>


<section id="news">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="main-news">
                    <h2 class="section-title"><?php echo lang('Son Haberler'); ?></h2>
                    <?php if (! empty($latestNews)): ?>
                        <div class="row">
                            <?php $this->view('news/widget/list-two', ['newscast' => $latestNews]) ?>
                        </div>
                    <?php endif ?>
                </div>


                <div class="galleries">
                    <h2 class="section-title"><?php echo lang('Galeriler'); ?></h2>
                    <div class="row">
                        <?php foreach ($homeGalleries as $index => $gallery): ?>
                            <div class="column <?php echo $index == 0 ? 'col-md-8':'col-md-4'; ?>">
                                <div class="item <?php echo $index == 0 ? 'big':''; ?>">
                                    <img src="<?php echo getImage($gallery->image, 'gallery', 480, 300); ?>" alt="<?php echo htmlspecialchars($gallery->title); ?>">
                                    <div class="images">
                                        <i class="fa fa-camera"></i> <?php echo $gallery->imageCount; ?> <?php echo lang('Fotoğraf'); ?>
                                    </div>
                                    <div class="detail">
                                        <a href="<?php echo clink(['@gallery', $gallery->slug]); ?>" title="<?php echo htmlspecialchars($gallery->title); ?>">
                                            <h3><?php echo $gallery->title; ?></h3>
                                        </a>
                                    </div>
                                </div>


                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="more">
                        <a class="more btn btn-default btn-sm" href="<?php echo clink(['@gallery']); ?>" title="<?php echo lang('Tüm Galeriler'); ?>">
                            <i class="fa fa-camera"></i> <?php echo lang('Tüm Galeriler'); ?>
                        </a>
                    </div>
                </div>


                <?php if (! empty($homeCategories)): ?>
                    <?php foreach ($homeCategories as $homeCategory): ?>
                        <div class="main-news">
                            <h2 class="section-title"><?php echo $homeCategory->title; ?></h2>
                            <div class="row">
                                <?php $this->view('news/widget/list-two', ['newscast' => $homeCategory->news]) ?>
                            </div>
                            <div class="more">
                                <a class="more btn btn-default btn-sm" href="<?php echo clink([$homeCategory->slug]); ?>" title="<?php echo lang('Tüm Haberler'); ?>">
                                    <i class="fa fa-newspaper-o"></i> <?php echo lang('Tüm Haberler'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
