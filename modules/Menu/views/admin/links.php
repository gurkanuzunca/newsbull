 <?php foreach ($records as $item): ?>
<tr>
    <td><abbr title="<?php echo $item->hint ?>"><?php echo $item->title ?></abbr></td>
    <td><?php echo $item->link ?></td>
    <td class="text-right">
        <a class="btn btn-xs btn-danger menu-insert"
           data-module="<?php echo $item->module ?>"
           data-id="<?php echo $item->id ?>"
           data-title="<?php echo htmlspecialchars($item->title) ?>"
           data-hint="<?php echo htmlspecialchars($item->hint) ?>"
           data-link="<?php echo $item->link ?>">
            <i class="fa fa-plus"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>

<?php if (count($records) == 0): ?>
<tr>
    <td colspan="50">Kayıt bulunamadı.</td>
</tr>
<?php endif; ?>