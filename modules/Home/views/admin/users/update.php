<div class="row">
    <form action="" method="post" enctype="multipart/form-data">

        <div class="col-md-6 col-md-offset-3">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">

                    <?php echo bsFormText('username', 'Kullanıcı Adı', array('required' => true, 'value' => $record->username)) ?>
                    <?php echo bsFormPassword('password', 'Parola') ?>
                    <?php echo bsFormDropdown('group', 'Kullanıcı Grubu', array(
                        'required' => true,
                        'value' => $record->groupId,
                        'options' => prepareForSelect($this->appmodel->getGroups(), 'id', 'name', 'Seçin')
                    )) ?>

                </div>

                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('users') ?>">Vazgeç</a>
                </div>

            </div>
        </div>

    </form>
</div>