
<div class="gallery-content common-typography">
    <?php echo $gallery->content; ?>
</div>

<div class="images-serial">
    <?php foreach ($gallery->images as $image): ?>
        <div class="item">
            <?php if (! empty($image->title)): ?>
                <div class="title"><?php echo $image->title; ?></div>
            <?php endif; ?>
            <div class="image">
                <img src="<?php echo getImage($image->image, 'gallery/images/wide', 750); ?>" alt="<?php echo htmlspecialchars(! empty($image->title) ? $image->title : $gallery->title); ?>">
            </div>
            <?php if (! empty($image->content)): ?>
                <div class="content common-typography"><?php echo $image->content; ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</div>
