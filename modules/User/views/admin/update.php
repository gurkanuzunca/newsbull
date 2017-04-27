
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo bsFormText('username', 'Kullanıcı Adı', ['required' => true, 'value' => $record->username]) ?>
                    <?php echo bsFormText('name', 'Ad', ['required' => true, 'value' => $record->name]) ?>
                    <?php echo bsFormText('surname', 'Soyad', ['required' => true, 'value' => $record->surname]) ?>
                    <?php echo bsFormText('email', 'E-mail', ['required' => true, 'value' => $record->email]) ?>
                    <?php echo bsFormPassword('password', 'Parola') ?>
                    <?php echo bsFormImage('image', 'Avatar', ['value' => $record->avatar, 'path' => 'public/upload/user/avatar']) ?>
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
                    <?php echo bsFormDropdown('status', 'Durum', ['value' => $record->status, 'options' => ['verified' => 'Onaylı', 'unverified' => 'Onaysız']]) ?>
                    <?php echo bsFormText('createdAt', 'Oluşturulma', ['value' => $this->date->set($record->createdAt)->datetime(), 'disabled' => true]) ?>
                    <?php echo bsFormText('updatedAt', 'Düzenlenme', ['value' => $this->date->set($record->updatedAt)->datetime(), 'disabled' => true]) ?>
                </div>
            </div>
        </div>
    </form>
</div>