<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Ekle</div>
                <div class="panel-body">
                    <?php echo bsFormText('username', 'Kullanıcı Adı', ['required' => true]) ?>
                    <?php echo bsFormText('name', 'Ad', ['required' => true]) ?>
                    <?php echo bsFormText('surname', 'Soyad', ['required' => true]) ?>
                    <?php echo bsFormText('email', 'E-mail', ['required' => true]) ?>
                    <?php echo bsFormPassword('password', 'Parola', ['required' => true]) ?>
                    <?php echo bsFormImage('image', 'Avatar') ?>
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
                    <?php echo bsFormDropdown('status', 'Durum', ['options' => ['verified' => 'Onaylı', 'unverified' => 'Onaysız']]) ?>
                </div>
            </div>
        </div>
    </form>
</div>