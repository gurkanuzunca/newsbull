
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo bsFormText('title', 'Başlık', ['required' => true, 'value' => $record->title]) ?>
                    <?php echo bsFormText('icon', 'İkon', ['required' => true, 'value' => $record->icon]) ?>
                    <p class="help-block">İkon tam class ismi yazılmalı. Örnek: "fa fa-facebook". Font-awesome için <a href="http://fontawesome.io/icons/" target="_blank">tıklayın</a>.</p>
                    <?php echo bsFormText('link', 'Bağlantı', ['required' => true, 'value' => $record->link]) ?>
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