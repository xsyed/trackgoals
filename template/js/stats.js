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

    async function getHabitChartData() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getBarChartData.php?habit_id=' + parseInt(urlHabitId));

        const data = await response.json();

        let pointer = 0;

        let months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
        let count = [];

        for(let i = 1;i<=12;i++){
            if(parseInt(data[pointer]["month"]) == i){
                count.push(parseInt(data[pointer]["count"]))
                pointer++;
            } else {
                count.push(0);
            }
        }


        let chartdata = {
            labels: months,
            datasets: [
                {
                    label: 'Completed',
                    backgroundColor: [
                        "#5969ff",
                        "#ff407b",
                        "#25d5f2",
                        "#ffc750",
                        "#2ec551",
                        "#7040fa",
                        "#ff004e",
                        "#5969ff",
                        "#ff407b",
                        "#25d5f2",
                        "#ffc750",
                        "#2ec551"
                    ],
                    hoverBackgroundColor: '#CCCCCC',
                    hoverBorderColor: '#666666',
                    data: count
                }
            ]
        };


        let myChart = $("#myChart");

        let barGraph = new Chart(myChart, {
            type: 'bar',
            data: chartdata,
            options:{
                scales:{
                    y: {
                        display: true,

                        beginAtZero: true,
                        steps: 10,
                        stepValue: 5,
                        max: 31

                    }
                }
            }
        });

    }

    async function getUserInfo() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/settings/getUserInfo.php?userId=' + userId);

        const data = await response.json();

        if(data.length > 0){

            if(data[0].photo == "default.png"){
                $("#profilePic").attr("src","./template/images/"+data[0].photo);
            } else {
                $("#profilePic").attr("src","./template/profileimages/"+data[0].photo);
            }

        } else {
            toast.fire({
                icon: 'error',
                title: 'Unable to receive user info!'
            }).then((result) => {

            })
        }

    }
    getUserInfo();
    getScore();
    getHabitChartData();
    getHabitDetails();
    getHabitCurrStreak();
    getHabitMaxStreak();



});

