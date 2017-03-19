<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="row">
    <form action="" method="post" enctype="multipart/form-data">

        <?php foreach ($this->positions as $position => $positionClass): ?>
            <div class="<?php echo $positionClass; ?>">
                <?php foreach ($this->groupsToPositions[$position] as $group): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-plus-square"></i> <?php echo $this->groups[$group]['title'] ?></div>
                        <div class="panel-body">
                            <?php echo $this->createForm('insert', $this->definitions['columns'][$group]) ?>
                        </div>
                        <?php if ($group === 'default'): ?>
                            <div class="panel-footer">
                                <button class="btn btn-success" type="submit">Gönder</button>
                                <button class="btn btn-success" type="submit" name="redirect" value="records">Kaydet ve Listeye Dön</button>
                                <a class="btn btn-default" href="<?php echo moduleUri('records') ?>">Vazgeç</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </form>
</div>