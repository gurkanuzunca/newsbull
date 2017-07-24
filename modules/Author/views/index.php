
<section id="main">
    <div class="container">

        <h1 class="section-title strong"><?php echo $this->module->arguments->title; ?></h1>
        <ul class="breadcrumb">
            <li><a href="./" title="<?php echo lang('Anasayfa'); ?>"><?php echo lang('Anasayfa'); ?></a> </li>
            <li><a href="<?php echo clink(['@author']) ?>" title="<?php echo htmlspecialchars($this->module->arguments->title); ?>"><?php echo $this->module->arguments->title; ?></a> </li>
        </ul>
        <div class="authors">
            <div class="row">
                <?php foreach ($authors as $author): ?>
                    <div class="col-md-3">
                        <div class="item">
                            <a href="<?php echo clink(['@author', $author->slug]); ?>" title="<?php echo htmlspecialchars($author->fullname); ?>">
                                <img src="<?php echo getImage($author->image, 'author', 300, 300); ?>" alt="<?php echo htmlspecialchars($author->fullname); ?>">
                            </a>
                            <div class="detail">
                                <a href="<?php echo clink(['@author', $author->slug]); ?>" title="<?php echo htmlspecialchars($author->fullname); ?>">
                                    <h3><?php echo $author->fullname; ?></h3>
                                    <p><?php echo $author->about; ?></p>
                                </a>
                                <a class="btn btn-success btn-sm" href="<?php echo clink(['@author', $author->slug]); ?>" title="<?php echo htmlspecialchars($author->fullname); ?>">
                                    Yazarın tüm yazıları
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
