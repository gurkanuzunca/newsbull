<section id="main">
    <div class="container">
        <div class="account">
            <div class="row">
                <div class="col-md-3">
                    <?php $this->view('user/widget/menu') ?>
                </div>

                <div class="col-md-9">
                    <h1 class="section-title">Bilgilerim</h1>

                    <div class="row">
                        <div class="col-md-7">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="form-username">Kullanıcı Adınız</label>
                                    <input class="form-control" name="username" id="form-username" type="text" required="required" tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="form-name">Adınız</label>
                                    <input class="form-control" name="name" id="form-name" type="text" required="required" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="form-surname">Soyadınız</label>
                                    <input class="form-control" name="surname" id="form-surname" type="text" required="required" tabindex="3">
                                </div>

                                <button class="btn btn-success" type="submit" tabindex="4">Güncelle</button>

                            </form>
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>
</section>
