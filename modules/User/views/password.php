<section id="main">
    <div class="container">
        <div class="account">
            <div class="row">
                <div class="col-md-3">
                    <?php $this->view('user/widget/menu') ?>
                </div>

                <div class="col-md-9">


                    <div class="row">
                        <div class="col-sm-9">
                            <h1 class="section-title">Parola Değiştir</h1>

                            <?php echo $this->alert->flash(['error', 'success']); ?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="form-oldpassword">Şuanki Parolanız</label>
                                    <input class="form-control" name="oldpassword" id="form-oldpassword" type="password" required="required" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="form-newpassword">Yeni Parolanız</label>
                                    <input class="form-control" name="newpassword" id="form-newpassword" type="password" required="required" tabindex="2">
                                </div>
                                <button class="btn btn-success" type="submit" tabindex="3">Değiştir</button>

                            </form>
                        </div>
                        <div class="col-md-3">
                            <?php $this->view('user/widget/card') ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
