<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="<?php echo base_url('/') ?>" />

    <link rel="stylesheet" type="text/css" href="public/admin/assets/compiled.css" />
    <?php foreach ($this->assets->css() as $css): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css ?>" />
    <?php endforeach; ?>
    <link rel="stylesheet" type="text/css" href="public/admin/css/main.css" />

    <script type="text/javascript" src="public/admin/assets/compiled.js"></script>
    <?php foreach ($this->assets->js() as $js): ?>
        <script type="text/javascript" src="<?php echo $js ?>"></script>
    <?php endforeach; ?>
    <script type="text/javascript" src="public/admin/js/main.js"></script>

</head>
<body>

<?php $this->view($view, @$data); ?>

</body>
</html>
