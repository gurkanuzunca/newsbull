<section id="slider" class="hidden-xs">
    <div class="container">
        <div data-ride="carousel" class="carousel slide" id="slider-carousel">
            <div class="carousel-inner">
                <?php foreach ($sliders as $index => $slider): ?>
                    <div class="item <?php echo $index === 0 ? 'active':''; ?>">
                        <?php if (! empty($slider->link)): ?>
                        <a href="<?php echo $slider->link; ?>" title="<?php echo htmlspecialchars($slider->title); ?>">
                        <?php endif; ?>
                            <img src="<?php echo getImage($slider->image, 'slider', 1142, 400); ?>" alt="<?php echo htmlspecialchars($slider->title); ?>">

                            <div class="hero">
                                <div class="caption">
                                    <h2><?php echo $slider->title; ?></h2>
                                    <?php if (! empty($slider->summary)): ?>
                                        <p><?php echo $slider->summary; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php if (! empty($slider->link)): ?>
                        </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="indicators">
                <ol class="carousel-indicators">
                    <?php foreach ($sliders as $index => $slider): ?>
                        <li class="<?php echo $index === 0 ? 'active':''; ?>" data-slide-to="<?php echo $index; ?>" data-target="#slider-carousel"></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <a class="left carousel-control" href="#slider-carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#slider-carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
</section>