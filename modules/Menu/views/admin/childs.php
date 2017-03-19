
<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-table"></i> <?php echo $this->moduleTitle ?></div>
    <div class="panel-toolbar clearfix">
        <div class="row">
            <div class="col-md-4">
                <?php if ($this->permission('delete')): ?>
                    <a class="btn btn-sm btn-info checkall" data-toggle="button"><i class="fa fa-check-square-o"></i> Hepsini Seç</a>
                    <a class="btn btn-sm btn-danger deleteall" href="<?php echo moduleUri('delete') ?>"><i class="fa fa-trash-o"></i></a>
                <?php endif; ?>
                <?php if ($this->permission('insert')): ?>
                    <a id="modal-modules-button" class="btn btn-sm btn-success" href="<?php echo moduleUri('insert', $parent->id) ?>"><i class="fa fa-plus"></i> Yeni Kayıt</a>
                <?php endif; ?>

                <a id="order-update" class="btn btn-sm btn-info hide" href="<?php echo moduleUri('order') ?>"><i class="fa fa-check-square"></i> Sırayı Güncelle</a>
            </div>
            <div class="col-md-8 text-right">
                <?php $this->view('filter') ?>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th width="40" class="text-center"><i class="fa fa-ellipsis-v"></i></th>
            <th width="50">#</th>
            <th>Başlık</th>
            <th>Bağlantı</th>
            <th width="100" class="text-center">Alt Menü</th>
            <th width="100" class="text-center">Sıra</th>
            <th width="100" class="text-right">İşlem</th>
        </tr>

        </thead>
        <tbody class="sortable">
        <?php foreach ($records as $item): ?>
            <tr data-id="<?php echo $item->id ?>">
                <td class="text-center"><input type="checkbox" class="checkall-item" value="<?php echo $item->id ?>" /></td>
                <td><?php echo $item->id ?></td>
                <td><?php echo $item->title ?></td>
                <td><?php echo $item->link ?></td>
                <td class="text-center"><a class="btn btn-success btn-xs" href="<?php echo moduleUri('childs', $item->id) ?>"><i class="fa fa-link"></i> <?php echo $item->childs ?></a></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a class="btn btn-xs btn-info disabled"><?php echo $item->order ?></a>
                        <?php if (! $this->input->get() || $this->input->get('page')): ?>
                            <a class="btn btn-xs btn-default sortable-handle"><i class="fa fa-arrows"></i></a>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="text-right">
                    <?php if ($this->permission('update')): ?>
                        <a class="btn btn-xs btn-primary" href="<?php echo moduleUri('update', $item->id) ?>"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                    <?php if ($this->permission('delete')): ?>
                        <a class="btn btn-xs btn-danger confirm-delete" href="<?php echo moduleUri('delete', $item->id) ?>"><i class="fa fa-trash-o"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (! empty($pagination)): ?>
        <div class="panel-footer">
            <?php echo $pagination ?>
        </div>
    <?php endif; ?>
</div>


<div id="modal-modules" class="modal" data-backdrop="static" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Menü Listesi</h4>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#static" data-toggle="tab" data-url="<?php echo $this->module ?>/static">Sabitler</a></li>
                            <?php foreach ($modules as $module): ?>
                                <li><a href="#<?php echo $module->name ?>" data-toggle="tab" data-url="<?php echo moduleUri('module', $module->name) ?>"><?php echo $module->title ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane" id="static">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><i class="fa fa-link"></i> Bağlantılar</div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="40%">Başlık</th>
                                            <th>Bağlantı</th>
                                            <th width="37"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><abbr title="Anasayfa">Anasayfa</abbr></td>
                                            <td>@home</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-danger menu-insert"
                                                   data-module="home"
                                                   data-id=""
                                                   data-title="Anasayfa"
                                                   data-hint="Anasayfa"
                                                   data-link="@home">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><abbr title="Boş Bağlantı">Boş Bağlantı</abbr></td>
                                            <td>#</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-danger menu-insert"
                                                   data-module=""
                                                   data-id=""
                                                   data-title="Boş Bağlantı"
                                                   data-hint="Boş Bağlantı"
                                                   data-link="#">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php foreach ($modules as $module): ?>
                                <div class="tab-pane" id="<?php echo $module->name ?>">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><i class="fa fa-link"></i> Bağlantılar</div>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th width="40%">Başlık</th>
                                                <th>Bağlantı</th>
                                                <th width="37"></th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" class="btn btn-primary">Tamam</a>
            </div>
        </div>
    </div>
</div>