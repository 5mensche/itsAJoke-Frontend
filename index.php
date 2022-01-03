<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonym" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            let apiUrl = "http://itsajoke.5mensche.ch/api/";
            let jokeId = null;
            let toast;
            let oldJokeId = null;
            loadNewJoke();
            function loadNewJoke(showMsg = false) {
                loadTop5();
                $.get(apiUrl + "jokes/random", function (data) {
                    if (data == null || data.status != 200) {
                        showToast("Loading joke", "Error", "Error while loading new Joke!", "bg-danger");
                    } else {
                        jokeId = data.id;
                        if (jokeId == oldJokeId) {
                            loadNewJoke();
                        } else {
                            oldJokeId = jokeId;
                            document.getElementById("joke").innerHTML = data.joke;
                            document.getElementById("rating").innerHTML = "Rating: <span class='badge badge-pill text-light bg-primary'>" + data.rating + "</span>";
                            if (showMsg) {
                                showToast("Loading joke", "Success", "successfully loaded new joke.", "bg-success");
                            }
                        }
                    }
                }).fail(function () {
                    showToast("Loading joke", "Error", "Error while loading new Joke!", "bg-danger");
                });
            }
            function loadTop5() {
                $.get(apiUrl + "jokes/listtop5", function (data) {
                    if (data == null || data.status != 200) {
                        showToast("Loading joke", "Error", "Error while loading new Joke!", "bg-danger");
                    } else {
                        let c = 1;
                        let top5 = document.getElementById('top5');
                        top5.innerHTML = '';
                        data.jokes.forEach(joke => {
                            let el = document.createElement("div");
                            el.innerHTML = "<span class='text-light'>" + c + ". <span class='badge badge-pill bg-primary text-light'>" + joke.rating + "</span> " + joke.joke + "</span>";
                            el.classList.add('py-3')
                            top5.appendChild(el);
                            c++;
                        });
                    }
                }).fail(function () {
                    showToast("Loading joke", "Error", "Error while loading new top Jokes!", "bg-danger");
                });
            }
            function rate(id, rating) {
                if (id != null) {
                    $.post(apiUrl + "jokes/rate", { id: id, rating: rating })
                        .done(function (data) {
                            if (data.status == 200) {
                                if (rating == 2) {
                                    showToast("Dislike", "Success", "Disliked successfully", "bg-success");
                                } else {
                                    showToast("Like", "Success", "Liked successfully", "bg-success");
                                }
                                loadNewJoke();
                            } else {
                                showToast("Rating joke", "Error", "Error while rating Joke!", "bg-danger");
                            }
                        })
                        .fail(function () {
                            showToast("Loading joke", "Error", "Error while rating Joke!", "bg-danger");
                        });
                } else {
                    showToast("Loading joke", "Error", "Error while rating Joke!", "bg-danger");
                }
            }
            function like() {
                rate(jokeId, 1);
            }
            function dislike() {
                rate(jokeId, 2);
            }
            function showToast(title, status, message, cclass) {
                document.getElementById("toastHeader").classList.remove("bg-success");
                document.getElementById("toastHeader").classList.remove("bg-danger");
                document.getElementById("toastTitle").textContent = title;
                document.getElementById("toastStatus").textContent = status;
                document.getElementById("toastMessage").textContent = message;
                document.getElementById("toastHeader").classList.add(cclass);
                toast = new bootstrap.Toast(document.getElementById("liveToast")).show();
            }
        </script>
        <style>
            .bg-image {
                background-image: url('https://images.pexels.com/photos/5962574/pexels-photo-5962574.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
                background-repeat: no-repeat;
                background-size: 100% 100%;
                filter: blur(8px);
                -webkit-filter: blur(8px);
                width: 100%;
                height: 100%;
                position: absolute;
                z-index: -1;
            }
        </style>
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
