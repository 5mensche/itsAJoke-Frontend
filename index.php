<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $apiUrl = 'http://10.123.45.2/api/';

    function apiGet($path) {
        global $apiUrl;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . $path); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);;
    }
    function apiPost($path, $payload) {
        global $apiUrl;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . $path);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    $joke = apiGet('joke');

    #echo apiPost('rate', 'rating=0&id=1')['type'];
    if(isset($_GET['rating']) && isset($_GET['jokeId'])) {
        if(!empty($_GET['rating']) 
        && is_numeric($_GET['rating']) 
        && !empty($_GET['jokeId'])
        && is_numeric($_GET['jokeId'])) {
            apiPost('rate', 'rating=' . $_GET['rating'] . '&jokeId=' . $_GET['jokeId'])['type'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonym">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>ItsAJoke | 5 Mensche</title>
</head>
<body style="height: 100vh;">
    <div style="height: 100%;" class="d-flex justify-content-center align-items-center">
        <div>
            <h5 class="d-block"><?=$joke['message'];?></h5>
            <h6><a class="d-block" href="?rating=1&jokeId=2">Like</a><a href="?rating=2&jokeId=1">Dislike</a></h6>
        </div>
    </div>
</body>
</html>
