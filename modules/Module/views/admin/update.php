
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6 col-md-offset-3">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-edit"></i> Kayıt Düzenle</div>
                <div class="panel-body">

                    <?php
                    foreach ($record->arguments as $argument) {
                        $argument->arguments['value'] = $argument->value;
                        echo call_user_func_array('bsForm'. ucfirst($argument->type), array($argument->name, $argument->title, $argument->arguments));
                    }
                    ?>

                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Kaydet</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('records') ?>">Vazgeç</a>
                </div>
            </div>
        </div>
    </form>
</div>

