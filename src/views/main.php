<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if(!$isDev): ?>
        <link rel="stylesheet" type="text/css" href="<?= siteUrl('assets/style.css') ?>" />
    <?php endif; ?>
    <title>Eng app</title>
</head>
<body>
    <div id="app"></div>
    
    <script>
        var siteUrl = '<?= siteUrl() ?>';
         window.assetUrl  = '<?= siteUrl("assets/") ?>';
    </script>
    <script src="<?= siteUrl('assets/app.js') ?>"></script>
</body>
</html>




