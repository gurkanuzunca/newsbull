<section id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <form class="login-form" action="" method="post">
                    <h1 class="section-title strong">Hesap Oluştur</h1>

                    <?php echo $this->alert->flash(['error', 'success']); ?>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="form-email">E-mail adresiniz</label>
                                <input class="form-control" name="email" id="form-email" type="email" required="required" autofocus="autofocus" tabindex="1">
                                <p class="help-block">E-mail adresinize doğrulama maili gönderilecektir.</p>
                            </div>
                            <div class="form-group">
                                <label for="form-password">Parolanız</label>
                                <input class="form-control" name="password" id="form-password" type="password" required="required" tabindex="2">
                                <p class="help-block">Parolanız en az 6 karakterden oluşmalıdır.</p>
                            </div>
                            <div class="form-group">
                                <label for="form-name">Adınız</label>
                                <input class="form-control" name="name" id="form-name" type="text" required="required" tabindex="3">
                            </div>
                            <div class="form-group">
                                <label for="form-surname">Soyadınız</label>
                                <input class="form-control" name="surname" id="form-surname" type="text" required="required" tabindex="4">
                            </div>

                            <button class="btn btn-success btn-block" type="submit" tabindex="5">Oluştur</button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        Hesabınız varsa <a href="<?php echo clink(['@user', 'giris']) ?>" title="Yeni hesap oluştur">giriş yapın</a>.
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
