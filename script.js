'use strict';

let apiUrl = 'https://itsajoke.5mensche.ch/api/';
let currentJokeId = null;

let btnRefresh = document.querySelector('#btn-refresh');
let btnLike = document.querySelector('#btn-like');
let btnDislike = document.querySelector('#btn-dislike');

let jokeEL = document.querySelector('#joke');
let ratingEL = document.querySelector('#rating');
let top5El = document.querySelector('#top5');
let toast;

let currentTaskComplete = true;

function init() {
    createTop5();
    refresh(false);
}

function refresh(showMsg = true) {
    if(currentTaskComplete) {
        getRandomJoke(showMsg);
        getTop5();
    }
}

function rate(id, rating) {
    if (id != null || rating != null) {
        $.post(apiUrl + 'jokes/rate', {id: id, rating: rating})
        .done((data) => {
            if(data == null || data.status != 200) {
                showToast("Rating joke", "Error", "Error while rating Joke!", "bg-danger");
                return;
            }
            if (rating == 1) {
                showToast("Like", "Success", "Liked successfully", "bg-success");
            } else {
                showToast("Dislike", "Success", "Disliked successfully", "bg-success");
            }
            refresh(false);
        });
    }
}

function createTop5() {
    for (let i = 1; i <= 5; i++) {
        let div = document.createElement('div');
        div.classList.add('py-3')

        let place = document.createElement('span');
        place.id = `top--${i}--place`;
        place.textContent = `${i}.`;

        let rating = document.createElement('span');
        rating.id = `top--${i}--rating`;
        rating.classList.add('badge', 'badge-pill', 'bg-primary', 'mx-1');
        rating.textContent = '0';

        let joke = document.createElement('span');
        joke.id = `top--${i}--joke`;

        div.append(place);
        div.append(rating);
        div.append(joke);

        top5El.appendChild(div);
    }
}

function getRandomJoke(showMsg = false) {
    currentTaskComplete = false;
    $.get(apiUrl + 'jokes/random', (data) => {
        if(data == null || data.status != 200) {
            showToast("Loading joke", "Error", "Error while loading new Joke!", "bg-danger");
            return;
        }

        if(showMsg) {
            showToast("Loading joke", "Success", "successfully loaded new joke.", "bg-success");
        }
        currentTaskComplete = true;

        currentJokeId = data.id;
        jokeEL.textContent = data.joke;
        ratingEL.textContent = data.rating;
    });
}

function getTop5() {
    currentTaskComplete = false;
    $.get(apiUrl + 'jokes/listtop5', (data) => {
        if(data == null || data.status != 200) {
            showToast("Loading joke", "Error", "Error while loading new top Jokes!", "bg-danger");
            return;
        }

        currentTaskComplete = true;

        let c = 1;
        data.jokes.forEach(joke => {
            let t5RatingEl = document.querySelector(`#top--${c}--rating`);
            let t5JokeEl = document.querySelector(`#top--${c}--joke`);

            t5RatingEl.textContent = joke.rating;
            t5JokeEl.textContent = joke.joke;

            c++;
        });
    });
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

btnRefresh.addEventListener('click', refresh);
btnLike.addEventListener('click', () => {rate(currentJokeId, 1)});
btnDislike.addEventListener('click',  () => {rate(currentJokeId, 2)});

init();