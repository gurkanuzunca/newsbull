
<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-table"></i> Kurulabilir Modüller</div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="40" class="text-center"><i class="fa fa-ellipsis-v"></i></th>
                    <th>Modül</th>
                    <th width="100" class="text-center">Kurulmuş</th>
                    <th width="100" class="text-right">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($copiedModules as $item): ?>
                    <tr>
                        <td></td>
                        <td><?php echo ucfirst($item->name) ?> Modülü</td>
                        <td class="text-center">
                            <?php if ($item->installed === true): ?>
                                <span class="text-success"><i class="fa fa-check"></i></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <?php if ($this->isRoot() && $item->installed === false): ?>
                                <a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Kur" href="admin/install/<?php echo $item->name ?>"><i class="fa fa-plug"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-table"></i> Ambardaki Modüller</div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="40" class="text-center"><i class="fa fa-ellipsis-v"></i></th>
                    <th>Modül</th>
                    <th width="100" class="text-center">Kurulmuş</th>
                    <th width="100" class="text-center">Kopyalanmış</th>
                    <th width="100" class="text-right">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($repositoryModules as $item): ?>
                    <tr>
                        <td></td>
                        <td><?php echo ucfirst($item->name) ?> Modülü</td>
                        <td class="text-center">
                            <?php if ($item->installed === true): ?>
                                <span class="text-success"><i class="fa fa-check"></i></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($item->copied === true): ?>
                                <span class="text-success"><i class="fa fa-check"></i></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <?php if ($this->isRoot()): ?>
                                <a class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Kopyala" href="<?php echo moduleUri('init', $item->name) ?>"><i class="fa fa-cloud-upload"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
