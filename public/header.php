<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css" />

    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/navbar.css" />

    <?php echo "<!--".basename(get_included_files()[0])."-->"; ?>
    <?php
        function noExtension($name) {
            return substr($name, 0, strrpos($name, '.'));
        }
        echo '<link rel="stylesheet" type="text/css" href="css/' . noExtension(basename(get_included_files()[0])) . '.css" />';
    ?>

    <link rel="icon" type="image/x-icon" href="img/assets/favicon.ico">

    <link rel="preconnect" href="https://fonts.googleapis.com">  
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/navbar.js"></script>

    <title>Jamco</title>
</head>
