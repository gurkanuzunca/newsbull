
<div class="row">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-8">
            <?php echo $this->alert->flash(['error', 'success']); ?>

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Kayıt Düzenle</div>
                <div class="panel-body">
                    <?php echo bsFormTextarea('content', 'Yorum', ['required' => true, 'value' => $record->content]) ?>
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
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Bilgiler</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Kullanıcı</label>
                        <p class="form-control-static">
                            <a href="<?php echo makeUri('admin', 'user', 'update', $record->userId) ?>">
                                <?php echo $record->userName ?>
                            </a>
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Haber</label>
                        <p class="form-control-static">
                            <a href="<?php echo makeUri('admin', 'news', 'update', $record->newsId) ?>"><?php echo $record->newsTitle ?></a>
                            <a class="fa fa-external-link text-primary" href="<?php echo clink(['@news', $record->categorySlug, $record->newsSlug]) ?>" data-toggle="tooltip" data-placement="top" title="Habere git" target="_blank"></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-plus-square"></i> Yayımla</div>
                <div class="panel-body">
                    <?php echo bsFormDropdown('status', 'Durum', ['value' => $record->status, 'options' => ['published' => 'Yayında', 'unpublished' => 'Yayında Değil']]) ?>
                    <?php echo bsFormText('createdAt', 'Oluşturulma', ['value' => $this->date->set($record->createdAt)->datetime(), 'disabled' => true]) ?>
                    <?php echo bsFormText('updatedAt', 'Düzenlenme', ['value' => $this->date->set($record->updatedAt)->datetime(), 'disabled' => true]) ?>
                </div>
            </div>
        </div>
    </form>
</div>