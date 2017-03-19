<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="<?php echo base_url('/') ?>" />

    <link rel="stylesheet" type="text/css" href="public/admin/assets/compiled.css" />
    <?php foreach ($this->assets->css() as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css ?>" />
    <?php endforeach; ?>
    <link rel="stylesheet" type="text/css" href="public/admin/css/main.css" />

    <script type="text/javascript" src="public/admin/assets/compiled.js"></script>
    <?php foreach ($this->assets->js() as $js): ?>
        <script type="text/javascript" src="<?php echo $js ?>"></script>
    <?php endforeach; ?>
    <script type="text/javascript" src="public/admin/js/main.js"></script>

</head>
<body>
<header id="header">
    <div class="header-brand">
        <a class="brand-text" href="admin">Sirius Panel</a>
    </div>
    <div class="header-toolbar clearfix">
        <div class="navigation">
            <ul class="nav navbar-right">
                <li data-toggle="tooltip" data-placement="left" title="Siteyi Göster">
                    <a href="./" target="_blank"><i class="fa fa-globe"></i></a>
                </li>
                <li class="dropdown" data-toggle="tooltip" data-placement="left" title="Diller">
                    <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag"></i></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($this->config->item('languages') as $language => $value): ?>
                            <li>
                                <a href="admin/home/language/<?php echo $language ?>?ref=<?php echo $this->module == 'home' ? '' : moduleUri('records') ?>">
                                    <?php echo $value ?>
                                    <?php if ($this->language == $language): ?>
                                        <i class="fa fa-check"></i>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown" data-toggle="tooltip" data-placement="left" title="Kullanıcılar">
                    <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/home/users"><i class="fa fa-user"></i> Kullanıcılar</a></li>
                        <li><a href="admin/home/groups"><i class="fa fa-key"></i> Kullanıcı Grupları</a></li>
                    </ul>
                </li>
                <li class="dropdown" data-toggle="tooltip" data-placement="left" title="Ayarlar">
                    <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/home/options">Genel Ayarları</a></li>
                        <li><a href="admin/module/records">Modül Ayarları</a></li>
                        <li><a href="admin/module/repository">Yüklenebilir Modüller</a></li>
                    </ul>
                </li>
                <li class="profile dropdown" data-toggle="tooltip" data-placement="left" title="Profil">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <div class="image"><?php echo $this->user->username[0]; ?></div>
                        <strong>Oturum (<?php echo $this->user->username; ?>)</strong>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="admin/home/password"><i class="fa fa-lock"></i> Parola Değiştir</a></li>
                        <li><a href="admin/home/logout"><i class="fa fa-sign-out"></i> Oturumu Kapat</a></li>
                    </ul>
                </li>
            </ul>
        </div>


    </div>
</header>
<?php
$exceptModules = array('home', 'module');
?>
<aside id="sidebar">
    <div class="sidemenu">
        <ul>
            <li><a href="admin/home/dashboard"><i class="fa fa-desktop"></i> Önizleme</a></li>
            <?php foreach ($this->getModules($exceptModules) as $module): ?>
                <li><a href="admin/<?php echo $module->name ?>/records"><i class="fa <?php echo !empty($module->icon) ? $module->icon : 'fa-chevron-circle-right' ?>"></i> <?php echo $module->title ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>


<section id="main">
    <div class="container-fluid">

        <div class="clearfix">
            <div class="pull-left">
                <ul class="breadcrumb">
                    <?php foreach ($this->utils->breadcrumbs() as $bread): ?>
                        <li>
                            <?php if (!empty($bread['url'])): ?>
                                <a href="<?php echo $bread['url'] ?>"><?php echo $bread['title'] ?></a>
                            <?php else: ?>
                                <?php echo $bread['title'] ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="pull-right">
                <?php if ($this->haveModuleArguments()): ?>
                    <a class="btn btn-success" href="admin/module/update/<?php echo $this->module ?>"><i class="fa fa-cogs"></i> Modül Ayarları</a>
                <?php endif; ?>
            </div>
        </div>

        <?php $this->view($view, $data); ?>
    </div>
</section>

<footer id="footer">
    <div class="container-fluid">
        Sirius Panel (<?php echo $this->siriusVersion ?>)
    </div>
</footer>


<div id="modal-confirm-delete" class="modal" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Uyarı!</h4>
            </div>
            <div class="modal-body">
                <p>Kayıt(lar) sistemden tamamen silinecek. İşlemi geri alma şansınız yoktur.</p>
                <p>İşlemi gerçekleştirmek istediğinize emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-danger">Hayır</a>
                <a id="confirm-true" class="btn btn-primary">Evet</a>
            </div>
        </div>
    </div>
</div>


<div id="modal-relation" class="modal" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Kayıtlar</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-success">Tamam</a>
            </div>
        </div>
    </div>
</div>


<div id="modal-plupload" class="modal" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Resim Yükle</h4>
            </div>
            <div class="modal-body">
                <div id="plupload-filelist"></div>
            </div>
            <div class="modal-footer">
                <a id="plupload-pickfiles" class="btn btn-success"><i class="fa fa-picture-o"></i> Dosya Seçin</a>
                <a id="plupload-cancel" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times"></i> İptal</a>
                <a id="plupload-upload" class="btn btn-primary"><i class="fa fa-upload"></i> Yükle</a>
                <a id="plupload-okay" class="btn btn-success disabled"><i class="fa fa-check"></i> Tamam</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
