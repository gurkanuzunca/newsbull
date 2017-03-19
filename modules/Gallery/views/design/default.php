<div class="images-default">
    <div data-ride="carousel" class="carousel slide" id="gallery-carousel">
        <div class="carousel-inner">
            <?php foreach ($gallery->images as $index => $image): ?>
                <div class="item <?php echo $index === 0 ? 'active':''; ?>">
                    <img src="<?php echo getImage($image->image, 'gallery/images/medium', 750, 370); ?>" alt="<?php echo htmlspecialchars(! empty($image->title) ? $image->title : $gallery->title); ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <a class="left carousel-control" href="#gallery-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#gallery-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>

<div class="gallery-content common-typography">
    <?php echo $gallery->content; ?>
</div>
