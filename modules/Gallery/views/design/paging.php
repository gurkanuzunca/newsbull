
<div class="gallery-content common-typography">
    <?php echo $gallery->content; ?>
</div>

<div class="images-serial">
    <div class="item">
        <?php if (! empty($image->title)): ?>
            <div class="title"><?php echo $image->title; ?></div>
        <?php endif; ?>
        <div class="image">
            <a href="<?php echo clink(['@gallery', $gallery->slug], ['resim' => $imageNext]); ?>" title="<?php echo lang('Sonraki'); ?>">
                <img src="<?php echo getImage($image->image, 'gallery/images/medium', 750, 470); ?>" alt="<?php echo htmlspecialchars(! empty($image->title) ? $image->title : $gallery->title); ?>">
            </a>
        </div>
        <?php if (! empty($image->content)): ?>
            <div class="content common-typography"><?php echo $image->content; ?></div>
        <?php endif; ?>
    </div>

</div>
