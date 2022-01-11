let apiUrl = "/api/";
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