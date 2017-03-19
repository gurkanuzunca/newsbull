<div id="login" class="container margined">
    <div class="col-md-4 col-md-offset-4">
        <form action="" method="post">
            <div class="panel panel-default">

                <div class="panel-heading">Sisteme Giriş</div>
                <div class="panel-body">
                        <?php echo $this->alert->flash('error') ?>

                        <div class="input-group form-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" placeholder="Kullanıcı adı" name="username" value="<?php echo set_value('username') ?>">
                        </div>

                        <div class="input-group form-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Parola" name="password">
                        </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success btn-sm" type="submit">Giriş Yap</button>
                </div>
            </div>
        </form>
    </div>
</div>