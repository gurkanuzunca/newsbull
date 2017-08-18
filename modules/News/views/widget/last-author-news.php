<div id="last-author-news">
    <?php foreach ($lastAuthorNews as $authorNews): ?>
        <div class="item">
            <div class="row">
                <div class="column col-sm-3">
                    <a href="<?php echo clink([$authorNews->category->slug, $authorNews->slug]); ?>" title="<?php echo htmlspecialchars(! empty($authorNews->listTitle) ? $authorNews->listTitle : $authorNews->title); ?>">
                        <img src="<?php echo getImage($authorNews->author->image, 'author', 300, 300); ?>" alt="<?php echo htmlspecialchars($authorNews->author->fullname); ?>">
                    </a>
                </div>
                <div class="column col-sm-9">
                    <a href="<?php echo clink([$authorNews->category->slug, $authorNews->slug]); ?>" title="<?php echo htmlspecialchars(! empty($authorNews->listTitle) ? $authorNews->listTitle : $authorNews->title); ?>">
                        <h3><?php echo ! empty($authorNews->listTitle) ? $authorNews->listTitle : $authorNews->title; ?></h3>
                        <div class="author"><?php echo $authorNews->author->fullname; ?></div>
                        <div class="date"><?php echo makeDate($authorNews->publishedAt)->dateWithName(); ?></div>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>