$(function(){

    let serverDate = document.getElementById("currDate").value;
    let scoreElem = document.getElementById("score");
    let totalCheckin = document.getElementById("totalCheckin");
    let currStreak = document.getElementById("currStreak");
    let bestStreak = document.getElementById("bestStreak");
    let habitTxt = document.getElementById("habitTxt");

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const urlHabitId = urlParams.get('id')

    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    })

    async function getScore() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getScore.php?userId=' + userId);

        const data = await response.json();
        scoreElem.innerHTML = data["Score"];

        console.log(data);
    }

    async function getHabitDetails() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getHabitStatById.php?habit_id=' + parseInt(urlHabitId));

        const data = await response.json();

        habitTxt.innerHTML = data["name"];
        totalCheckin.innerHTML = data["total"]+" days";

    }

    async function getHabitMaxStreak() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getMaxHabitStreak.php?habit_id=' + parseInt(urlHabitId));

        const data = await response.json();


        bestStreak.innerHTML = data["streak"]+" days";

    }

    async function getHabitCurrStreak() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getHabitCurrStreak.php?habit_id=' + parseInt(urlHabitId));

        const data = await response.json();


        currStreak.innerHTML = data["streak"]+" days";

    }

    getScore();
    getHabitDetails();
    getHabitCurrStreak();
    getHabitMaxStreak();



    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );


});

