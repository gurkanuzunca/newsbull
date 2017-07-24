<?php
$title = isset($title) ? $title : $record->title;
?>
<div class="common-buttons">
    <a class="btn facebook share-box" href="https://facebook.com/sharer.php?u=<?php echo current_url() ?>" title="<?php echo lang('Facebook\'ta Paylaş') ?>"><i class="fa fa-facebook"></i> <?php echo lang('Facebook\'ta Paylaş') ?></a>
    <a class="btn twitter share-box" href="https://twitter.com/share?url=<?php echo current_url() ?>&text=<?php echo htmlspecialchars($title) ?>" title="<?php echo lang('Twitter\'da Paylaş') ?>"><i class="fa fa-twitter"></i> <?php echo lang('Twitter\'da Paylaş') ?></a>
    <a class="btn google share-box" href="https://plus.google.com/share?url=<?php echo current_url() ?>" title="<?php echo lang('Google+\'da Paylaş') ?>"><i class="fa fa-google-plus"></i> <?php echo lang('Google+\'da Paylaş') ?></a>
    <?php if (isset($record->visited)): ?>
        <span class="btn visited"><?php echo lang('Görüntülenme'); ?>: <strong><?php echo $record->visited ?></strong></span>
    <?php endif; ?>
</div>