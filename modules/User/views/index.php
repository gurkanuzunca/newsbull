<section id="main">
    <div class="container">
        <div class="account">
            <div class="row">
                <div class="col-md-3">
                    <div class="menu">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong>Hesap Yönetimi</strong></div>
                            <div class="list-group">
                                <a class="list-group-item" href="<?php echo clink(['@user', 'profil']); ?>">Bilgilerim</a>
                                <a class="list-group-item" href="<?php echo clink(['@user', 'parola']); ?>">Prola Değiştir</a>
                                <a class="list-group-item" href="<?php echo clink(['@user', 'avatar']); ?>">Profil Resmi Yükle</a>
                                <a class="list-group-item" href="<?php echo clink(['@user', 'bildirim']); ?>">Bildirimler</a>
                                <a class="list-group-item" href="<?php echo clink(['@user', 'cikis']); ?>">Çıkış</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-sm-9">
                            <h1 class="section-title">fg</h1>
                        </div>
                        <div class="col-md-3">
                            <div class="avatar">
                                <img class="img-thumbnail" src="<?php echo getAvatar($this->getUser()->avatar) ?>" alt="<?php echo htmlspecialchars($this->getUser()->username); ?>">
                            </div>

                            <div class="card">
                                <h1><?php echo $this->getUser()->name ?> <?php echo $this->getUser()->surname ?></h1>
                                <ul class="list-unstyled">
                                    <li>
                                        <span>Görünen İsim</span><br>
                                        <?php echo $this->getUser()->username ?>
                                    </li>
                                    <li>
                                        <span>Üyelik Tarihi</span><br>
                                        <?php echo $this->date->set($this->getUser()->createdAt)->dateWithName() ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
