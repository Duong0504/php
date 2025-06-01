<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (!empty($pageTitle)?$pageTitle: "Website MVC" ); ?></title>
    <link rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/client/css/reset.css">
    <link rel="stylesheet" href="<?php echo _WEB_ROOT;?>/public/assets/client/css/style.css">
</head>
<body>
    <?php
        $this->render("blocks/header", $sub_content);
        $this->render($content, $sub_content);                
        $this->render("blocks/footer");
    ?>
    <script src="<?php echo _WEB_ROOT;?>/public/assets/client/js/script.js"></script>
</body>
</html>