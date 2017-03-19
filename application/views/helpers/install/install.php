<div class="container margined">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Kurulum</div>
            <div class="panel-body">
                <?php foreach ($messages as $message): ?>
                    <p><?php echo $message ?></p>
                <?php endforeach; ?>
            </div>
            <div class="panel-footer">
                <a class="btn btn-success btn-sm" href="admin/<?php echo $this->module; ?>/records">Modüle git</a>
                <a class="btn btn-success btn-sm" href="admin">Panele dön</a>
            </div>
        </div>
    </div>
</div>
