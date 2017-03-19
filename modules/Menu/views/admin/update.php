
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">

                    <?php echo bsFormText('title', 'Başlık', array('required' => true, 'value' => $record->title)) ?>
                    <?php echo bsFormText('hint', 'Alt Başlık', array('required' => true, 'value' => $record->hint)) ?>
                    <?php echo bsFormText('link', 'Bağlantı', array('required' => true, 'value' => $record->link)) ?>


                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Kaydet</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('childs', $record->parentId) ?>">Vazgeç</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">

                    <?php echo bsFormText('htmlID', 'Html ID', array('value' => $record->htmlID)) ?>
                    <?php echo bsFormText('htmlClass', 'Html Class', array('value' => $record->htmlClass)) ?>
                    <?php echo bsFormDropdown('target', 'Target', array('value' => $record->target, 'options' => array('_self' => 'Aynı Pencere','_target' => 'Yeni Pencere'))) ?>


                </div>
            </div>
        </div>
    </form>
</div>

