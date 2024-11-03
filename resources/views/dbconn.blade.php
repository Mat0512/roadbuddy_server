<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
try {
    DB::connection()->getPdo();
    if(DB::connection()->getDatabaseName()){
        echo "Successfully connected to the DB";
    }else{
        die("Could not find the database. Please check your configuration.");
    }
} catch (\Exception $e) {
    error_log($e, 3, "error.log");

    die("Could not open connection to database server.  Please check your configuration.");
}
?>
</body>
</html>
