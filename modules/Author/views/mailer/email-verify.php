<h3>E-Mail Adresinizi Doğrulayın</h3>
<p class="lead">Herşey tamam! Sadece bir adım kaldı.</p>
<p>Üyelik işlemini tamamlamak ve e-mail adresinizi doğrulamak için aşağıdaki bağlantıya tıklayın. Doğrulama işlemi yapılamazsa lütfen bizimle iletişime geçin.</p>
<p><a class="btn" href="<?php echo base_url(clink(['@user', 'dogrula', $token])) ?>">E-mail adresini doğrula!</a></p>
<p class="small">
    Bağlantıya tıklayamıyorsanız adresi kopyalayıp tarayıcınıza yağıştırın.<br>
    <a href="<?php echo base_url(clink(['@user', 'dogrula', $token])) ?>"><?php echo base_url(clink(['@user', 'dogrula', $token])) ?></a>
</p>