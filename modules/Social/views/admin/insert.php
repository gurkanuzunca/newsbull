<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Ekle</div>
                <div class="panel-body">
                    <?php echo bsFormText('title', 'Başlık', ['required' => true]) ?>
                    <?php echo bsFormText('icon', 'İkon', ['required' => true]) ?>
                    <p class="help-block">İkon tam class ismi yazılmalı. Örnek: "fa fa-facebook". Font-awesome için <a href="http://fontawesome.io/icons/" target="_blank">tıklayın</a>.</p>
                    <?php echo bsFormText('link', 'Bağlantı', ['required' => true]) ?>
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