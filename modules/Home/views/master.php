<!DOCTYPE html>
<html lang="<?php echo $this->language ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->stack->get('options.metaTitle') ?></title>
    <meta name="description" content="<?php echo $this->stack->get('options.metaDescription') ?>">
    <meta name="keywords" content="<?php echo $this->stack->get('options.metaKeywords') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="<?php echo base_url('/') ?>" />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700&amp;subset=latin-ext" />
    <link rel="stylesheet" type="text/css" href="public/assets/compiled.css" />
    <?php foreach ($this->assets->css() as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css ?>" />
    <?php endforeach; ?>
    <link rel="stylesheet" type="text/css" href="public/css/main.css" />

    <script type="text/javascript" src="public/assets/compiled.js"></script>
    <?php foreach ($this->assets->js() as $js): ?>
        <script type="text/javascript" src="<?php echo $js ?>"></script>
    <?php endforeach; ?>
    <script type="text/javascript" src="public/js/main.js"></script>

    <?php if ($this->stack->has('options.ogType')): ?>
        <meta property="og:type" content="<?php echo $this->stack->has('options.ogType') ?>" />
    <?php endif; ?>
    <?php if ($this->stack->has('options.ogTitle')): ?>
        <meta property="og:title" content="<?php echo htmlspecialchars($this->stack->has('options.ogTitle')) ?>" />
    <?php endif; ?>
    <?php if ($this->stack->has('options.ogDescription')): ?>
        <meta property="og:description" content="<?php echo htmlspecialchars($this->stack->has('options.ogDescription')) ?>" />
    <?php endif; ?>
    <?php if ($this->stack->has('options.ogImage')): ?>
        <meta property="og:image" content="<?php echo base_url('/').$this->stack->has('options.ogImage') ?>"/>
    <?php endif; ?>

    <meta property="og:url" content="<?php echo current_url() ?>"/>

    <?php echo $this->stack->get('options.customMeta') ?>
</head>
<body>

<section id="header">
    <div class="head">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="logo">
                        <a href="<?php echo clink('@home'); ?>" title="<?php echo lang('Anasayfa'); ?>">Newsbull</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form">
                        <form action="<?php echo clink(['@search']); ?>" method="get">
                            <div class="input-group">
                                <input name="q" type="text" class="form-control" placeholder="<?php echo lang('Ne arıyorsun?'); ?>">
                                <span class="input-group-btn"><button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" aria-expanded="false" data-target="#navbar-collapse" data-toggle="collapse" type="button"><i class="fa fa-bars"></i> MENÜ</button>
                </div>
                <div id="navbar-collapse" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php foreach ($this->menu->get('main') as $menu): ?>
                            <li><a href="<?php echo clink($menu->link) ?>" title="<?php echo htmlspecialchars($menu->hint); ?>"><?php echo $menu->title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right user-account">
                        <?php if ($this->auth->logged()): ?>
                            <li><a class="login" href="<?php echo clink(['@profile', $this->auth->user()->id]) ?>" title="Profilim"><i class="fa fa-user"></i> <?php echo $this->getUser()->username ?></a></li>
                            <li><a class="create" href="<?php echo clink(['@user']) ?>" title="Hesabım"><i class="fa fa-cog"></i> Hesabım</a></li>
                        <?php else: ?>
                            <li><a class="login" href="<?php echo clink(['@user', 'giris']) ?>" title="Giriş yap"><i class="fa fa-sign-in"></i> Giriş yap</a></li>
                            <li><a class="create" href="<?php echo clink(['@user', 'olustur']) ?>" title="Hesap oluştur"><i class="fa fa-user"></i> Hesap oluştur</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</section>


<?php $this->view($view); ?>


<section id="footer">
    <div class="body">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="logo">Newsbull</div>
                    <div class="about">Açık kaynak haber sitesi yazılımıdır. <strong>Newsbull henüz kararlı sürüm değildir.</strong> Geliştirilmeye devam etmektedir. Geliştirmeleri Github ve Trello üzerinden takip edebilirsiniz. Hata, görüş ve önerilerinizi Github aracılı ile iletebilirsiniz.</div>
                </div>
                <div class="col-sm-8 col-sm-offset-1">
                    <div class="row">
                        <?php foreach ($this->menu->get('footer') as $menu): ?>
                            <div class="col-sm-4">
                                <h4 class="caption"><?php echo $menu->title; ?></h4>
                                <?php if (! empty($menu->childs)): ?>
                                    <nav>
                                        <ul>
                                            <?php foreach ($menu->childs as $child): ?>
                                                <li><a href="<?php echo clink($child->link) ?>" title="<?php echo htmlspecialchars($child->hint); ?>"><?php echo $child->title; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </nav>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="foot">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    Newsbull - Haber bizden alınır :)
                </div>
                <div class="col-sm-6">
                    <div class="social">
                        <?php echo lang('Sosyal Medya'); ?>
                        <ul>
                            <?php foreach ($this->social->all() as $social): ?>
                                <li><a href="<?php echo $social->link; ?>" title="<?php echo htmlspecialchars($social->title); ?>" target="_blank"><i class="<?php echo $social->icon; ?>"></i></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
