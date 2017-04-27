<div class="avatar">
    <img class="img-thumbnail" src="<?php echo getAvatar($this->getUser()->avatar) ?>" alt="<?php echo htmlspecialchars($this->getUser()->username); ?>">
</div>

<div class="card">
    <h1><?php echo $this->getUser()->name ?> <?php echo $this->getUser()->surname ?></h1>
    <ul class="list-unstyled">
        <li>
            <span>Kullanıcı Adı</span><br>
            <?php echo $this->getUser()->username ?>
        </li>
        <li>
            <span>Üyelik Tarihi</span><br>
            <?php echo $this->date->set($this->getUser()->createdAt)->dateWithName() ?>
        </li>
    </ul>
</div>