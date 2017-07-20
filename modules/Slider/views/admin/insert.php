<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Ekle</div>
                <div class="panel-body">
                    <?php echo bsFormText('title', 'Başlık', ['required' => true]) ?>
                    <?php echo bsFormTextarea('summary', 'Özet') ?>
                    <?php echo bsFormText('link', 'Bağlantı', ['required' => true]) ?>
                    <div class="alert alert-info">
                        Dış bağlantı için <strong>http(s)://</strong> ön eki ile birlikte tam adresi yazınız. Örn: <strong>http://newsbull.org</strong><br>
                        İç bağlantı için domainden sonraki url'i yazmanız yeterlidir ancak isterseniz iç bağlantılarda da tam adresi yazabilirsiniz. <br>
                        Örn: <strong>kategori/haber-adresi</strong> ya da <strong>http://newsbull.org/kategori/haber-adresi</strong>
                    </div>
                    <?php echo bsFormImage('image', 'Görsel') ?>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-success" type="submit">Gönder</button>
                    <button class="btn btn-success" type="submit" name="redirect" value="records">Kaydet ve Listeye Dön</button>
                    <a class="btn btn-default" href="<?php echo moduleUri('records') ?>">Vazgeç</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Yayımla</div>
                <div class="panel-body">
                    <?php echo bsFormDropdown('status', 'Durum', ['options' => ['published' => 'Yayında', 'unpublished' => 'Yayında Değil']]) ?>

                </div>
            </div>

        </div>
    </form>
</div>