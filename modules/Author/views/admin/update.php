
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo bsFormText('name', 'Ad', ['required' => true, 'value' => $record->name]) ?>
                    <?php echo bsFormText('surname', 'Soyad', ['required' => true, 'value' => $record->surname]) ?>
                    <?php echo bsFormTextarea('about', 'Hakkında', ['value' => $record->about]) ?>
                    <?php echo bsFormImage('image', 'Fotoğraf', ['value' => $record->image, 'path' => 'public/upload/author']) ?>
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
                    <?php echo bsFormDropdown('status', 'Durum', ['value' => $record->status, 'options' => ['published' => 'Yayında', 'unpublished' => 'Yayında Değil']]) ?>
                    <?php echo bsFormText('createdAt', 'Oluşturulma', ['value' => $this->date->set($record->createdAt)->datetime(), 'disabled' => true]) ?>
                    <?php echo bsFormText('updatedAt', 'Düzenlenme', ['value' => $this->date->set($record->updatedAt)->datetime(), 'disabled' => true]) ?>
                </div>
            </div>
        </div>
    </form>
</div>