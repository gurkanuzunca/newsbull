<?php foreach ($newscast as $news): ?>
    <div class="col-md-6">
        <div class="item">
            <div class="row">
                <div class="col-sm-6">
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
                <div class="col-sm-6">
                    <div class="detail">
                        <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars(! empty($news->listTitle) ? $news->listTitle : $news->title); ?>">
                            <h3><?php echo ! empty($news->listTitle) ? $news->listTitle : $news->title; ?></h3>
                            <div class="date">
                                <i class="fa fa-clock-o"></i> <?php echo makeDate($news->publishedAt)->dateWithName(); ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>