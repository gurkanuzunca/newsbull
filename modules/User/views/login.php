<?php //var_dump($this->auth) ?>
<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form class="login-form" action="" method="post">
                    <h1 class="section-title strong">Giriş Yap</h1>

                    <?php echo $this->alert->flash(['error', 'success']); ?>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="form-email">E-mail adresiniz</label>
                                <input class="form-control" name="email" id="form-email" type="email" required="required" autofocus="autofocus" tabindex="1">
                            </div>
                            <div class="form-group">
                                <small class="pull-right"><a href="<?php echo clink(['@user', 'parolami-unuttum']); ?>">Parolamı Unuttum?</a> </small>
                                <label for="form-password">Parolanız</label>
                                <input class="form-control" name="password" id="form-password" type="password" required="required" tabindex="2">
                            </div>

                            <button class="btn btn-success btn-block" type="submit" tabindex="3">Giriş Yap</button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        Henüz kayıt olmadıysanız <a href="<?php echo clink(['@user', 'olustur']) ?>" title="Yeni hesap oluştur">yeni hesap</a> oluşturun.
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
