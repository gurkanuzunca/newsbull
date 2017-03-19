
<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-table"></i> <?php echo $this->moduleTitle ?></div>
    <div class="panel-toolbar clearfix">
        <div class="row">
            <div class="col-md-5">
                <?php if ($this->permission('delete')): ?>
                    <a class="btn btn-sm btn-info checkall" data-toggle="button"><i class="fa fa-check-square-o"></i> Hepsini Seç</a>
                    <a class="btn btn-sm btn-danger deleteall" href="<?php echo moduleUri('delete') ?>"><i class="fa fa-trash-o"></i></a>
                <?php endif; ?>
                <?php if ($this->permission('insert')): ?>
                    <a class="btn btn-sm btn-success" href="<?php echo moduleUri('insert') ?>"><i class="fa fa-plus"></i> Yeni Kayıt</a>
                <?php endif; ?>

                <a id="order-update" class="btn btn-sm btn-info hide" href="<?php echo moduleUri('order') ?>"><i class="fa fa-check-square"></i> Sırayı Güncelle</a>
            </div>
            <div class="col-md-7 text-right">
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
            <th>Modül</th>
            <th width="100">Tür</th>
            <th width="100" class="text-center">Sıra</th>
            <th width="100" class="text-right">İşlem</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($records as $item): ?>
            <tr data-id="<?php echo $item->id ?>" <?php echo empty($item->controller) ? 'class="text-muted"':'' ?>>
                <td class="text-center"><?php if (empty($item->controller)): ?><input type="checkbox" class="checkall-item" value="<?php echo $item->id ?>" /><?php endif; ?></td>
                <td><?php echo $item->id ?></td>
                <td><?php echo $item->title ?></td>
                <td>@<?php echo $item->name ?></td>
                <td><?php echo ucfirst($item->type) ?></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a class="btn btn-xs btn-info disabled"><?php echo $item->order ?></a>
                        <?php if (! $this->input->get() || $this->input->get('page')): ?>
                            <a class="btn btn-xs btn-default sortable-handle"><i class="fa fa-arrows"></i></a>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="text-right">
                    <?php if ($this->permission('delete') && empty($item->controller)): ?>
                        <a class="btn btn-xs btn-danger confirm-delete" href="<?php echo moduleUri('delete', $item->id) ?>"><i class="fa fa-trash-o"></i></a>
                    <?php endif; ?>
                    <?php if ($this->permission('update') && $item->arguments > 0): ?>
                        <a class="btn btn-xs btn-primary" href="<?php echo moduleUri('update', $item->name) ?>"><i class="fa fa-edit"></i></a>
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