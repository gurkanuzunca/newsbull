<h3>Parolanızı sıfırlayın!</h3>
<p class="lead">Acele edin zaman kısıtlı!</p>
<p>Aşağıdaki bağlantıya tıklayarak parolanızı sıfırlayabilirsiniz. Parola sıfırlama bağlantısı 1 saat sonra iptal olacaktır.</p>
<p><a class="btn" href="<?php echo base_url(clink(['@user', 'parolami-sifirla', $token])) ?>">Parolamı sıfırla!</a></p>
<p class="small">
    Bağlantıya tıklayamıyorsanız adresi kopyalayıp tarayıcınıza yağıştırın.<br>
    <a href="<?php echo base_url(clink(['@user', 'parolami-sifirla', $token])) ?>"><?php echo base_url(clink(['@user', 'parolami-sifirla', $token])) ?></a>
</p>

<p class="small">
   Eğer parola sıfırlama talebi yapmadıysanız e-maili dikkate almayınız.
</p>