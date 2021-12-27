<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonym">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script>
        let apiUrl = 'http://itsajoke.5mensche.ch/api/';
        let jokeId = null;
        let toast;

        loadNewJoke();

        function loadNewJoke(showMsg = false) {
            $.get(apiUrl + 'jokes/random', function(data) {
                if(data == null || data.status != 200) {
                    showToast('Loading joke', 'Error', 'Error while loading new Joke!', 'bg-danger');
                } else {
                    jokeId = data.id;
                    document.getElementById('joke').textContent = data.joke;
                    if(showMsg) {
                        showToast('Loading joke', 'Success', 'successfully loaded new joke.', 'bg-success');
                    }
                }
            });
        }

        function rate(id, rating) {
            if(id != null) {
                $.post(apiUrl + 'jokes/rate', {id: id, rating: rating})
                .done(function(data) {
                    if(data.status == 200) {
                        loadNewJoke();
                    } else {
                        showToast('Loading joke', 'Error', 'Error while rating Joke!', 'bg-danger');
                    }
                });
            } else {
                showToast('Loading joke', 'Error', 'Error while rating Joke!', 'bg-danger');
            }
        }

        function like() {
            rate(jokeId, 1);
            showToast('Like', 'Success', 'Liked successfully', 'bg-success');
        }

        function dislike() {
            rate(jokeId, 2);
            showToast('Dislike', 'Success', 'Disliked successfully', 'bg-success');
        }

        function showToast(title, status, message, cclass) {
            //toast.hide();
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastStatus').textContent = status;
            document.getElementById('toastMessage').textContent = message;
            document.getElementById('toastHeader').classList.add(cclass);
            toast = new bootstrap.Toast(document.getElementById('liveToast')).show();
        }
    </script>

    <title>ItsAJoke | 5 Mensche</title>
</head>
<body style="height: 100vh;">
    <div style="height: 100%;" class="d-flex justify-content-center align-items-center">
        <div>
            <div id="joke"></div>
            <div>
                <a onclick="loadNewJoke(true)"><button type="button" class="btn btn-secondary">Refresh</button></a>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button id="likeBtn" onclick="like()" type="button" class="btn btn-success">Like</button>
                    <button id="dislikeBtn" onclick="dislike()" type="button" class="btn btn-danger">Dislike</button>
                </div>
            </div>
        </div>
    </div>
    <!-- TOAST START -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
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
