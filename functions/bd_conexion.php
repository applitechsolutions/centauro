<?php

// $conn = mysqli_init();
// mysqli_ssl_set($conn,NULL,NULL, "/home/site/wwwroot/functions/DigiCertGlobalRootCA.crt.pem", NULL, NULL);
// mysqli_real_connect($conn, "applitech-mysql-flexible.mysql.database.azure.com", "applitech", "28XHc5qt", "centauro", 3306, MYSQLI_CLIENT_SSL);

/*$conn = new mysqli('localhost', 'root', '', 'centauro');

if ($conn->connect_error) {
    echo $error -> $conn->connect_error;
}*/

    $connectstr_dbhost = '';
    $connectstr_dbname = '';
    $connectstr_dbusername = '';
    $connectstr_dbpassword = '';

    foreach ($_SERVER as $key => $value) {
        if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
            continue;
        }
        
        $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
        $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
        $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
        $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
    }

    $conn = mysqli_connect($connectstr_dbhost, $connectstr_dbusername, $connectstr_dbpassword,$connectstr_dbname);

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    /*echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
    echo "Host information: " . mysqli_get_host_info($conn) . PHP_EOL;

    mysqli_close($conn);*/

?>