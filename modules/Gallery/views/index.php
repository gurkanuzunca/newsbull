
<section id="main">
    <div class="container">

        <h1 class="section-title strong"><?php echo $this->module->arguments->title; ?></h1>
        <ul class="breadcrumb">
            <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a> </li>
            <li><a href="<?php echo clink(['@gallery']) ?>" title="<?php echo htmlspecialchars($this->module->arguments->title); ?>"><?php echo $this->module->arguments->title; ?></a> </li>
        </ul>
        <div class="galleries">
            <div class="row">
                <?php foreach ($galleries as $gallery): ?>
                    <div class="col-md-4">
                        <div class="item">
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
        </div>
    </div>
</section>
