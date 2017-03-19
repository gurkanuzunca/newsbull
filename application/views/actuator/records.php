
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
                    <a class="btn btn-sm btn-success" href="<?php echo moduleUri('insert', $this->parent === true && isset($parent) ? $parent->id : '') ?>"><i class="fa fa-plus"></i> Yeni Kayıt</a>
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
            <?php foreach ($this->columns as $column => $options): ?>
                <?php if (isset($options['show']['list']) && $options['show']['list'] === true): ?>
                    <th class="<?php echo @$options['class'] ?>" width="<?php echo @$options['width'] ?>">
                        <?php echo $options['label'] ?>
                    </th>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if ($this->parent === true): ?>
                <th width="100" class="text-center">Kayıtlar</th>
            <?php endif; ?>

            <?php if ($this->images === true): ?>
                <th width="100" class="text-center">Resimler</th>
            <?php endif; ?>
            <th width="100" class="text-right">İşlem</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php foreach ($records as $item): ?>
            <tr data-id="<?php echo $item->id ?>">
                <td><input type="checkbox" class="checkall-item" value="<?php echo $item->id ?>" /></td>
                <td><?php echo $item->id ?></td>
                <?php foreach ($this->columns as $column => $options): ?>
                    <?php if (isset($options['show']['list']) && $options['show']['list'] === true): ?>
                        <td class="<?php echo @$options['class'] ?>">
                            <?php if ($options['type'] === 'slug'): ?>
                                <?php echo $this->createModuleLink($item) ?>
                            <?php elseif ($options['type'] === 'order'): ?>
                                <div class="btn-group">
                                    <a class="btn btn-xs btn-info disabled"><?php echo $item->$column ?></a>
                                    <?php if (! $this->input->get() || $this->input->get('page')): ?>
                                        <a class="btn btn-xs btn-default sortable-handle"><i class="fa fa-arrows"></i></a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <?php if (isset($options['styles'])): ?>
                                    <?php echo $options['styles'][$item->$column] ?>
                                <?php else: ?>
                                    <?php echo $item->$column ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($this->parent === true): ?>
                    <td class="text-center"><a class="btn btn-success btn-xs" href="<?php echo moduleUri('records', $item->id)?>"><i class="fa fa-link"></i> <?php echo $item->childs ?></a></td>
                <?php endif; ?>
                <?php if ($this->images === true): ?>
                    <td class="text-center"><a class="btn btn-success btn-xs" href="<?php echo moduleUri('images', $item->id)?>"><i class="fa fa-image"></i> <?php echo $item->images ?></a></td>
                <?php endif; ?>

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

    <?php if (! empty($pagination)): ?>
        <div class="panel-footer">
            <?php echo $pagination ?>
        </div>
    <?php endif; ?>
</div>