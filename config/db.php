<?php
/*
    Since we are (now) using PDO, we will be specifying a Data Source Name (dsn) for portability
    For mysql, the dsn takes the form of 
        mysql:host=<hostname>; port=<optional_port>; dbname=<database_for connection>
        username : database username (when applicable)
        password : database password (when applicable)
        dbname : database name (used only so we can refer to it elsewhere in the code)
*/
return [
    'dsn' => 'mysql:host=localhost; port=3306; dbname=mwfcameroonsql2',
    'username' => 'root',
    'password' => ''
];