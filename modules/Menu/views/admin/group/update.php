
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6 col-md-offset-3">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">

                    <?php echo bsFormText('name', 'Etiket', array('required' => true, 'value' => $record->name)) ?>
                    <div class="help-block">Etiket menünün kod ile çağırılacağı parametredir. Tekil olmalıdır.</div>
                    <?php echo bsFormText('title', 'Başlık', array('required' => true, 'value' => $record->title)) ?>


                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Kaydet</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('records') ?>">Vazgeç</a>
                </div>
            </div>
        </div>
    </form>
</div>

