
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="section-title strong"><?php echo $this->module->arguments->title; ?></h1>
                <div class="category-news">
                    <?php foreach ($results as $module => $items): ?>
                        <?php if ($module === 'news'): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="image">
                                                <a href="<?php echo clink([$item->category->slug, $item->slug]); ?>" title="<?php echo htmlspecialchars($item->title); ?>">
                                                    <img src="<?php echo getImage($item->image, 'news/thumb', 480, 300); ?>" alt="<?php echo htmlspecialchars($item->title); ?>">
                                                </a>
                                                <?php if (isset($item->category)): ?>
                                                    <div class="category">
                                                        <a href="<?php echo clink([$item->category->slug]); ?>" title="<?php echo htmlspecialchars($item->category->title); ?>"><?php echo $item->category->title; ?></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <a href="<?php echo clink([$item->category->slug, $item->slug]); ?>" title="<?php echo htmlspecialchars($item->title); ?>">
                                                    <h3><?php echo $item->title; ?></h3>
                                                    <p><?php echo $item->summary; ?></p>
                                                    <div class="date">
                                                        <i class="fa fa-clock-o"></i> <?php echo makeDate($item->publishedAt)->dateWithName(); ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($module === 'gallery'): ?>
                            <?php foreach ($items as $item): ?>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="image">
                                                <a href="<?php echo clink(['@gallery', $item->slug]); ?>" title="<?php echo htmlspecialchars($item->title); ?>">
                                                    <img src="<?php echo getImage($item->image, 'gallery', 480, 300); ?>" alt="<?php echo htmlspecialchars($item->title); ?>">
                                                </a>
                                                <div class="images">
                                                    <i class="fa fa-camera"></i> <?php echo $item->imageCount ?> <?php echo lang('Fotoğraf'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <a href="<?php echo clink(['@gallery', $item->slug]); ?>" title="<?php echo htmlspecialchars($item->title); ?>">
                                                    <h3><?php echo $item->title; ?></h3>
                                                    <p><?php echo $item->summary; ?></p>
                                                    <div class="date">
                                                        <i class="fa fa-clock-o"></i> <?php echo makeDate($item->createdAt)->dateWithName(); ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
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
