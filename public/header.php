<?php
    // get filename, then include .css and .js if they exist
    function noExtension($name) {
        return substr($name, 0, strrpos($name, '.'));
    }
    $filename_no_ext = noExtension(basename(get_included_files()[0])); // get the topmost included file

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css" />

    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/navbar.css" />
    <?php $f = 'css/'.$filename_no_ext.'.css'; if(file_exists($f)) echo '<link rel="stylesheet" type="text/css" href="'.$f.'" />'; ?>
    
    <link rel="icon" type="image/x-icon" href="img/assets/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">  
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shave/5.0.0/jquery.shave.min.js" integrity="sha512-Hnpg/NnQLnyqCRvz4sMI4gSOAPe3JmQ7aPzAvE3VGudAvUVZTgsXbvuWrTJ6ak0/BIFZ/ArIIKb9dlE4CWlGLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js" integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="js/navbar.js"></script>
    <?php $f = 'js/'.$filename_no_ext.'.js'; if(file_exists($f)) echo '<script src="'.$f.'" ></script>'; ?>


    <title>Jamco</title>
</head>
