
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
                    <a class="btn btn-sm btn-success" href="<?php echo moduleUri('insert', isset($parent) ? $parent->id:'') ?>"><i class="fa fa-plus"></i> Yeni Kayıt</a>
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
            <th>Slug</th>
            <th width="150">Gösterim</th>
            <th width="10" class="text-center">Yorumlar</th>
            <th width="180">Yayımlanma</th>
            <th width="150">Durum</th>
            <th width="100" class="text-right">İşlem</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($records as $item): ?>
            <tr data-id="<?php echo $item->id ?>">
                <td class="text-center">
                    <input type="checkbox" class="checkall-item" value="<?php echo $item->id ?>" />
                </td>
                <td><?php echo $item->id ?></td>
                <td>
                    <?php echo $item->title ?>
                    <?php if (! empty($item->listTitle)): ?>
                        <i class="fa fa-info-circle text-primary" data-toggle="tooltip" data-placement="top" title="Liste Başlığı: <?php echo htmlspecialchars($item->listTitle) ?>"></i>
                    <?php endif; ?>
                </td>
                <td><?php echo $item->slug ?></td>
                <td><?php echo $item->visited ?></td>
                <td class="text-center"><a class="btn btn-success btn-xs" href="<?php echo makeUri('admin', 'comment', 'records', ['query' => ['newsId' => $item->id]])?>"><i class="fa fa-comment"></i> <?php echo $item->comments ?></a></td>
                <td><?php echo $this->date->set($item->publishedAt)->datetimeWithName() ?></td>
                <td>
                    <?php if ($item->status === 'unpublished'): ?>
                        <span class="label label-danger">Yayında Değil</span>
                    <?php else: ?>

                        <?php if ($this->date->set()->diff($item->publishedAt)->diffInvert() == 0): ?>
                            <span class="label label-warning">Zaman Ayarlı</span>
                        <?php else: ?>
                            <span class="label label-success">Yayında</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td class="text-right">
                    <a class="btn btn-xs btn-info" href="<?php echo clink(['@news', $item->categorySlug, $item->slug]) ?>" data-toggle="tooltip" data-placement="top" title="Habere git" target="_blank">
                        <i class="fa fa-external-link"></i>
                    </a>
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