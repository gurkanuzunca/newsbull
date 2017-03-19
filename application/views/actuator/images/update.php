<?php echo $this->alert->flash(['error', 'success']); ?>

<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo $this->createForm('update', $this->imageColumns, $record) ?>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <button class="btn btn-success" type="submit" name="redirect" value="images/@parentId">Kaydet ve Listeye Dön</button>
                    <a class="btn btn-default" href="<?php echo  moduleUri('images', $parent->id) ?>">Vazgeç</a>
                </div>
            </div>
        </div>
    </form>
</div>

