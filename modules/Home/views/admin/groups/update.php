

<div class="row">
    <div class="col-md-6">
        <?php echo $this->alert->flash(['error', 'success'], 'perms'); ?>

        <form action="<?php echo moduleUri('groupPermsUpdate', $record->id) ?>" method="post" enctype="multipart/form-data">


            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Yetkiler</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3">
                            <ul class="nav nav-pills nav-stacked">
                                <?php foreach ($modules as $module): ?>
                                    <li><a href="#<?php echo $module->name ?>" data-toggle="tab"><?php echo $module->title ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <?php foreach ($modules as $module): ?>
                                    <div class="tab-pane" id="<?php echo $module->name ?>">
                                        <?php foreach (explode(',', $module->permissions) as $perm): ?>
                                            <div class="checkbox">
                                                <label><?php echo form_checkbox("perms[$module->name][]", $perm, in_array($perm, isset($record->perms[$module->name]) ? $record->perms[$module->name] : array())) ?> <?php echo ucfirst($perm) ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('groups') ?>">Vazgeç</a>
                </div>

            </div>
        </form>
    </div>


    <div class="col-md-6">
        <?php echo $this->alert->flash(['error', 'success']); ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo bsFormText('name', 'Grup Adı', array('required' => true, 'value' => $record->name)) ?>
                </div>

                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('groups') ?>">Vazgeç</a>
                </div>

            </div>
        </form>
    </div>







</div>