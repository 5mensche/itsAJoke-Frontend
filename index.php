<?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    function apiGet($path) {
        $url = 'http://10.123.45.2/api/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $path); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
        return json_decode($output, true);;
    }

    $joke = apiGet('joke');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="styleshe>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integri>
    <title>5Mensche</title>
</head>
<body style="height: 100vh;">
    <div style="height: 100%;" class="d-flex justify-content-center align-items-center">
        <h5><?=$joke['message'];?></h5>
    </div>
</body>
</html>
