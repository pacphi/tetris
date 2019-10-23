isPause = false;

document.addEventListener("keydown", function (e) {
    let key = '';
    if (e.key === "ArrowDown") {
        e.preventDefault();
        key = "down";
    }
    if (e.key === "ArrowLeft") {
        e.preventDefault();
        key = "left";
    }
    if (e.key === "ArrowRight") {
        e.preventDefault();
        key = "right";
    }
    if (e.key === "w") {
        e.preventDefault();
        rotate(1);
    }
    if (e.key === "x") {
        e.preventDefault();
        rotate(-1);
    }
    if (e.key === "p") {
        isPause = !isPause;
        document.getElementById("grid").classList.toggle("pause");
        if (isPause) {
            clearInterval(timer);
            clearInterval(clearTimer);
        } else {
            interval();
            clearTimer = window.setInterval(clear, 1000);
        }
    }

    if (key && !isPause) {
        move(key);
    }

});

function move(direction = 'down') {
    fetch("?move=" + direction)
        .then(function (response) {
            return response.text();
        })
        .then(function (html) {
            document.body.innerHTML = html;
        });
}



function rotate(direction) {
    fetch("?rotate=" + direction)
        .then(function (response) {
            return response.text();
        })
        .then(function (html) {
            document.body.innerHTML = html;
        });
}

function speed() {
    let speed = 1000 - (document.getElementById('level').dataset.level * 100);
    if (speed < 100) {
        speed = 100;
    }
    return speed;
}

interval();
clearTimer = window.setInterval(clear, 1000);

function clear() {
    // have to clear and reset interval to change dynamically the timer
    clearInterval(timer);
    interval();
}

function interval() {
    let time = speed();
    console.log(time);
    timer = window.setInterval(move, time);
}

