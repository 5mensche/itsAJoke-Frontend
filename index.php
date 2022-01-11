<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonym" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script.js"></script>
        <title>ItsAJoke | 5 Mensche</title>
    </head>
    <body class="bg-dark" style="height: 100vh;">
        <div class="bg-image"></div>
        <div style="height: 100%;" class="d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="my-2 row">
                    <div class="mb-2">
                        <a onclick="loadNewJoke(true)"><button type="button" class="btn btn-secondary">Refresh</button></a>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button id="likeBtn" onclick="like()" type="button" class="btn btn-success">Like</button>
                            <button id="dislikeBtn" onclick="dislike()" type="button" class="btn btn-danger">Dislike</button>
                        </div>
                    </div>
                    <div class="p-2 col-md-8 col-12">
                        <div class="rounded bg-dark p-3 shadow">
                            <h3 class="text-light">It's a joke | 5 Mensche</h3>
                            <div class="text-light" id="rating"></div>
                            <h4 class="pt-2 text-light" id="joke"></h4>
                        </div>
                    </div>
                    <div class="p-2 col-md-4 col-12 ">
                        <div class="rounded bg-dark p-3 shadow">
                            <h3 class="text-light">Top 5</h3>
                            <div id="top5"></div>
                            <div>
                                <small><a target="_blank" class="link-dark text-decoration-none" href="https://aarongensetter.ch/imprint">Impressum</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TOAST START -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                <div id="toastHeader" class="toast-header text-light">
                    <strong id="toastTitle" class="me-auto"></strong>
                    <small id="toastStatus"></small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div id="toastMessage" class="toast-body"></div>
            </div>
        </div>
        <!-- TOAST END -->
    </body>
</html>
