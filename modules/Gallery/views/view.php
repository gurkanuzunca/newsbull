
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1 class="section-title strong"><?php echo $gallery->title; ?></h1>
                <ul class="breadcrumb">
                    <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a> </li>
                    <li><a href="<?php echo clink(['@gallery']) ?>" title="<?php echo htmlspecialchars($this->module->arguments->title); ?>"><?php echo $this->module->arguments->title; ?></a> </li>
                    <li><a href="<?php echo clink(['@gallery', $gallery->slug]) ?>" title="<?php echo htmlspecialchars($gallery->title); ?>"><?php echo $gallery->title; ?></a> </li>
                </ul>

                <div class="gallery-details">
                    <div class="common-summary">
                        <?php echo $gallery->summary; ?>
                    </div>

                    <?php $this->view('home/widget/share', ['record' => $gallery]) ?>

                    <?php $this->view('gallery/design/'. $gallery->design) ?>

                    <?php $this->view('home/widget/share', ['record' => $gallery]) ?>

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
