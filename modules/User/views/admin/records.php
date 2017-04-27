
<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="panel panel-default">
    <div class="panel-heading"><i class="fa fa-table"></i> <?php echo $this->moduleTitle; ?></div>
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
            <th>Kullanıcı Adı</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Email</th>
            <th width="150">Durum</th>
            <th width="100" class="text-right">İşlem</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($records as $item): ?>
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="checkall-item" value="<?php echo $item->id ?>" />
                </td>
                <td><?php echo $item->id ?></td>
                <td><?php echo $item->username ?></td>
                <td><?php echo $item->name ?></td>
                <td><?php echo $item->surname ?></td>
                <td><?php echo $item->email ?></td>
                <td>
                    <?php if ($item->status === 'unverified'): ?>
                        <span class="label label-danger">Onaylı Değil</span>
                    <?php else: ?>
                        <span class="label label-success">Onaylı</span>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <?php if ($this->permission('update')): ?>
                        <a class="btn btn-xs btn-primary" href="<?php echo moduleUri('update', $item->id)?>"><i class="fa fa-edit"></i></a>
                    <?php endif; ?>
                    <?php if ($this->permission('delete')): ?>
                        <a class="btn btn-xs btn-danger confirm-delete" href="<?php echo moduleUri('delete', $item->id) ?>"><i class="fa fa-trash-o"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (! empty($paginate)): ?>
        <div class="panel-footer">
            <?php echo $paginate['pagination'] ?>
        </div>
    <?php endif; ?>
</div>