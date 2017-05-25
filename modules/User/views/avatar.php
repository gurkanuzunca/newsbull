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
                            <h1 class="section-title">Bilgilerim</h1>

                            <?php echo $this->alert->flash(['error', 'success']); ?>

                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="form-name">Resim seçin</label>
                                    <input class="filestyle" type="file" name="avatar" tabindex="1">
                                </div>
                                <button class="btn btn-success" type="submit" tabindex="2" name="forpost">Güncelle</button>
                                <?php echo csrfToken(true); ?>
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
