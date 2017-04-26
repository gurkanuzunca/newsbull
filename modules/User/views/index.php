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
