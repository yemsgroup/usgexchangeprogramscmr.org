<?php

// Include the autoload register
include_once 'syteman/autoload.php';


if (isset($_POST['submit'])) {
    
    $config_file_path = __DIR__ . '\config\db.php';
    $writable_config_file = fopen($config_file_path, 'w');

    $new_content = "<?php
/*
    Since we are (now) using PDO, we will be specifying a Data Source Name (dsn) for portability
    For mysql, the dsn takes the form of 
        mysql:host=<hostname>; port=<optional_port>; dbname=<database_for connection>
        username : database username (when applicable)
        password : database password (when applicable)
        dbname : database name (used only so we can refer to it elsewhere in the code)
*/
return [
    'dsn' => '" . $_POST['dsn'] . "',
    'username' => '" . $_POST['db_user'] . "',
    'password' => '" . $_POST['db_password'] . "'
];";

    $file_created = fwrite($writable_config_file, $new_content);

    if($file_created) {

        fclose($writable_config_file);
        Run::redirect_to('index.php');

    }

} else {

    // Check if Correct DB info already provided.
    $db_file = include dirname(__FILE__) . '/config/db.php';
    try {

        $db = @new PDO($db_file['dsn'], $db_file['username'], $db_file['password']);
        Run::redirect_to('index.php');

    } catch (Exception $e) {

        $db = false;

    }

}

?>

<head>
    <!-- Page Title and Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Enter DB info.</title>

    <!-- Base URL -->
    <?=defined('BASE_URL')?'<base href="' . BASE_URL . '" target="" />':''; ?>

    <!-- Include CSS Styles if any -->
    <?php
        if (file_exists('content/themes/default/assets/css/main.css')) echo '<link rel="stylesheet" href="content/themes/default/assets/css/main.css" />';
    ?>
    
    <!-- Browser Icon -->
    <link rel="shortcut icon" href="<?=defined('BASE_URL') ? BASE_URL : $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/' . dirname($_SERVER['REQUEST_URI']); ?>/favicon.svg">

</head>

<body style="background:url(content/library/images/texture-bg.png) #2581c4;">
    <main>
        <div class="onboard">
            
            <?=isset($_GET['error']) ? '<div class="error">' . $_GET['error'] . '</div>' : ''; ?>
            
            <h3 class="title">Update DB Config</h3>
    
            <form action="" class="" method="post">
                <input type="text" name="dsn" class="" value="<?php echo isset($_GET['dsn']) ? $_GET['dsn'] : '' ?>" placeholder="DSN" />
                <input type="text" name="db_user" class="" value="<?php echo isset($_GET['username']) ? $_GET['username'] : '' ?>" placeholder="Database User" />
                <input type="text" name="db_password" class="" value="<?php echo isset($_GET['password']) ? $_GET['password'] : '' ?>" placeholder="Database Password" />
                <input type="submit" name="submit" class="" value="Update Config" />
            </form>
            
        </div>
    </main>
</body>