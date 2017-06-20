<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Ekle</div>
                <div class="panel-body">
                    <?php echo bsFormText('name', 'Ad', ['required' => true]) ?>
                    <?php echo bsFormText('surname', 'Soyad', ['required' => true]) ?>
                    <?php echo bsFormTextarea('about', 'Hakkında') ?>
                    <?php echo bsFormImage('image', 'Fotoğraf') ?>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <button class="btn btn-success" type="submit" name="redirect" value="records">Kaydet ve Listeye Dön</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('records') ?>">Vazgeç</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Yayımla</div>
                <div class="panel-body">
                    <?php echo bsFormDropdown('status', 'Durum', ['options' => ['published' => 'Yayında', 'unpublished' => 'Yayında Değil']]) ?>
                </div>
            </div>
        </div>
    </form>
</div>