<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Qatl::app()->getParam('appName', 'Test App'); ?>
        - <?= Qatl::app()->getParam('appDescription', ''); ?></title>
</head>
<body>

<div>
    <?= $content; ?>
</div>

</body>
</html>