$(function(){



    let dateTxt = document.getElementById("dateTxt");
    let serverDate = document.getElementById("currDate").value;
    let scoreElem = document.getElementById("score");
    dateTxt.innerHTML = "Today";

    let habitloader = document.getElementById("habitloader");
    let habitloaderCompleted = document.getElementById("habitloaderCompleted");
    let habitloaderSkipped = document.getElementById("habitloaderSkipped");


    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    })

    // Get the whole form, not the individual input-fields
    const form = document.getElementById('addHabitForm');

    /**
     * Add an onclick-listener to the whole form, the callback-function
     * will always know what you have clicked and supply your function with
     * an event-object as first parameter, `addEventListener` creates this for us
     */
    form.addEventListener('submit', function (event) {
        //Prevent the event from submitting the form, no redirect or page reload
        event.preventDefault();
        /**
         * If we want to use every input-value inside of the form we can call
         * `new FormData()` with the form we are submitting as an argument
         * This will create a body-object that PHP can read properly
         */
        const formattedFormData = new FormData(form);
        postData(formattedFormData);
    });

    async function postData(formattedFormData) {
        /**
         * If we want to 'POST' something we need to change the `method` to 'POST'
         * 'POST' also expects the request to send along values inside of `body`
         * so we must specify that property too. We use the earlier created
         * FormData()-object and just pass it along.
         */
        const response = await fetch('./controller/habits/addHabit.php', {
            method: 'POST',
            body: formattedFormData
        });
        /*
         * Because we are using `echo` inside of `handle_form.php` the response
         * will be a string and not JSON-data. Because of this we need to use
         * `response.text()` instead of `response.json()` to convert it to something
         * that JavaScript understands
         */
        const data = await response.text();
        //This should now print out the values that we sent to the backend-side
        if (data === "Success") {

            toast.fire({
                icon: 'success',
                title: 'New Habit Added!'
            }).then((result) => {

            })
            await getPendingHabits();
            await getCompletehabits();
            await getSkippedhabits();
            getScore();
        } else {
            toast.fire({
                icon: 'error',
                title: data
            })
        }

    }


    async function changeHabitStatus(habitid,status) {

        let formData = new FormData();
        formData.append("habit_id",habitid);
        formData.append("status",status);

        const response = await fetch('./controller/habits/updateStatus.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.text();

        if (data === "Success") {
            if(status === 2){
                toast.fire({
                    icon: 'success',
                    title: 'Habit skipped!'
                }).then((result) => {

                })
            } else{
                toast.fire({
                    icon: 'success',
                    title: 'woohoo! Habit done!'
                }).then((result) => {

                })
            }

            await getPendingHabits();
            await getCompletehabits();
            await getSkippedhabits();
            getScore();
        } else {
            toast.fire({
                icon: 'error',
                title: data
            })
        }
    }
    async function getScore() {

        let userId = document.getElementById("userId").value;

        const response = await fetch('./controller/habits/getScore.php?userId=' + userId);

        const data = await response.json();
        scoreElem.innerHTML = data["Score"];

        console.log(data);
    }

    async function getPendingHabits(choosedDate) {

        let userId = document.getElementById("userId").value;
        if(choosedDate == undefined){
            choosedDate = document.getElementById("currDate").value; //serverdate
        }

        const response = await fetch('./controller/habits/getPendingHabits.php?userId=' + userId + '&onDate=' + choosedDate);

        habitloader.style.display = "block";
        const data = await response.json();

        habitloader.style.display = "none";

        let penhabitsWrap = document.getElementById("penhabitsWrap");
        penhabitsWrap.innerHTML = "";

        if(data.length > 0){
            for (let i = 0; i < data.length; i++) {

                let habitName = '<div class="habitname">' +
                    '<span class="editContainer knox" id="editContainer_'+data[i].habit_id+'" >' +
                    '<input type="text" class="form-control"  value="'+data[i].name+'">' +
                    '<i class="bi bi-check-square editBtn" data-hbid="'+data[i].habit_id+'"></i>' +
                    '<i class="bi bi-x-square cancelBtn"></i></span>' +
                    '<h6 class="alert-heading habitTitle"><span class="habit_name"> ' + data[i].name + '</span> &nbsp; ' +
                    '<span class="statIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-graph-up-arrow statBtn" data-hbid="'+data[i].habit_id+'"></i></span> &nbsp;&nbsp;  ' +
                    '<span class="editIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-pencil"></i></span>&nbsp;' +
                    '<span class="deleteIcon"><i class="bi bi-trash deleteBtn" data-hbid="'+data[i].habit_id+'"></i></span>' +
                    '</h6>' +
                    '</div>';

                let outerDiv = document.createElement("div");
                outerDiv.innerHTML = habitName;

                let hbtdiv = document.createElement("div");
                let classes = ['habitbuttons'];
                hbtdiv.classList.add(...classes);

                let skipBtn = document.createElement("button");
                skipBtn.className = "skipbutton";
                skipBtn.innerHTML = '<i class="bi bi-flag"></i>';

                skipBtn.onclick = function() {

                    changeHabitStatus(data[i].habit_id,2);
                }

                hbtdiv.appendChild(skipBtn);

                let doneBtn = document.createElement("button");
                doneBtn.className = "donebutton";
                doneBtn.innerHTML = '<i class="bi bi-check-circle"></i>';
                doneBtn.onclick =  function() { changeHabitStatus(data[i].habit_id,1);}

                hbtdiv.appendChild(doneBtn);
                outerDiv.appendChild(hbtdiv);

                let classesToAdd = ['alert', 'alert-primary', 'alert-dismissible', 'fade', 'show', 'habit'];
                outerDiv.classList.add(...classesToAdd);

                penhabitsWrap.appendChild(outerDiv);
            }
        } else{
            penhabitsWrap.innerHTML += '<div class="w-100 p-3 mt-3 mb-3 text-center" style="background-color: #eee;">Good job! Let\'s do it everyday!</div>';
        }

        console.log(data);
    }

    async function getCompletehabits(choosedDate) {

        let userId = document.getElementById("userId").value;
        if(choosedDate == undefined){
            choosedDate = document.getElementById("currDate").value;
        }

        const response = await fetch('./controller/habits/getCompletedHabits.php?userId=' + userId + '&onDate=' + choosedDate);

        habitloaderCompleted.style.display = "block";
        const data = await response.json();

        habitloaderCompleted.style.display = "none";

        let comphabitsWrap = document.getElementById("comphabitsWrap");
        comphabitsWrap.innerHTML = "";

        if(data.length > 0){
            for (let i = 0; i < data.length; i++) {

                let habitName = '<div class="habitname">' +
                    '<span class="editContainer knox" id="editContainer_'+data[i].habit_id+'" >' +
                    '<input type="text" class="form-control"  value="'+data[i].name+'">' +
                    '<i class="bi bi-check-square editBtn" data-hbid="'+data[i].habit_id+'"></i>' +
                    '<i class="bi bi-x-square cancelBtn"></i></span>' +
                    '<h6 class="alert-heading habitTitle"><span class="habit_name"> ' + data[i].name + '</span> &nbsp; ' +
                    '<span class="statIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-graph-up-arrow statBtn" data-hbid="'+data[i].habit_id+'"></i></span> &nbsp;&nbsp;  ' +
                    '<span class="editIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-pencil"></i></span>&nbsp;' +
                    '<span class="deleteIcon"><i class="bi bi-trash deleteBtn" data-hbid="'+data[i].habit_id+'"></i></span>' +
                    '</h6>' +
                    '</div>';

                let outerDiv = document.createElement("div");
                outerDiv.innerHTML = habitName;

                let hbtdiv = document.createElement("div");
                let classes = ['habitbuttonsCompleted'];
                hbtdiv.classList.add(...classes);

                let doneBtn = document.createElement("button");
                doneBtn.className = "donebutton";
                doneBtn.setAttribute("type","button");
                doneBtn.setAttribute("data-bs-toggle","tooltip");
                doneBtn.setAttribute("data-bs-placement","top");
                doneBtn.setAttribute("title","Completed");

                doneBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i>';

                hbtdiv.appendChild(doneBtn);
                outerDiv.appendChild(hbtdiv);

                let classesToAdd = ['alert', 'alert-success', 'alert-dismissible', 'fade', 'show', 'habit'];
                outerDiv.classList.add(...classesToAdd);

                comphabitsWrap.appendChild(outerDiv);
            }
        } else{
            comphabitsWrap.innerHTML += '<div class="bg-light w-100 p-3 mt-3 mb-3 text-center" style="background-color: #eee;">Let\'s get going!</div>';
        }

        console.log(data);
    }

    async function getSkippedhabits(choosedDate) {


        let userId = document.getElementById("userId").value;

        if(choosedDate == undefined){
            choosedDate = document.getElementById("currDate").value;
        }

        const response = await fetch('./controller/habits/getSkippedHabits.php?userId=' + userId + '&onDate=' + choosedDate);

        habitloaderSkipped.style.display = "block";
        const data = await response.json();

        habitloaderSkipped.style.display = "none";

        let skiphabitsWrap = document.getElementById("skiphabitsWrap");
        skiphabitsWrap.innerHTML = "";

        if(data.length > 0){
            for (let i = 0; i < data.length; i++) {


                let habitName = '<div class="habitname">' +
                    '<span class="editContainer knox" id="editContainer_'+data[i].habit_id+'" >' +
                    '<input type="text" class="form-control"  value="'+data[i].name+'">' +
                    '<i class="bi bi-check-square editBtn" data-hbid="'+data[i].habit_id+'"></i>' +
                    '<i class="bi bi-x-square cancelBtn"></i></span>' +
                    '<h6 class="alert-heading habitTitle"><span class="habit_name"> ' + data[i].name + '</span> &nbsp; ' +
                    '<span class="statIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-graph-up-arrow statBtn" data-hbid="'+data[i].habit_id+'"></i></span> &nbsp;&nbsp;  ' +
                    ' <span class="editIcon" data-id="'+data[i].habit_id+'"><i class="bi bi-pencil"></i></span>&nbsp;' +
                    '<span class="deleteIcon"><i class="bi bi-trash deleteBtn" data-hbid="'+data[i].habit_id+'"></i></span>' +
                    '</h6>' +
                    '</div>';

                let outerDiv = document.createElement("div");
                outerDiv.innerHTML = habitName;

                let hbtdiv = document.createElement("div");
                let classes = ['habitbuttonsCompleted'];
                hbtdiv.classList.add(...classes);

                let doneBtn = document.createElement("button");
                doneBtn.className = "skipbutton";
                doneBtn.setAttribute("type","button");
                doneBtn.setAttribute("data-bs-toggle","tooltip");
                doneBtn.setAttribute("data-bs-placement","top");
                doneBtn.setAttribute("title","Skipped");

                doneBtn.innerHTML = '<i class="bi bi-flag-fill"></i>';

                hbtdiv.appendChild(doneBtn);
                outerDiv.appendChild(hbtdiv);

                let classesToAdd = ['alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'habit'];
                outerDiv.classList.add(...classesToAdd);

                skiphabitsWrap.appendChild(outerDiv);
            }
        } else{
            skiphabitsWrap.innerHTML += '<div class="bg-light w-100 p-3 mt-3 mb-3 text-center" style="background-color: #eee;">Well done! No Habit skipped!</div>';
        }

        console.log(data);
    }

    getPendingHabits();
    getCompletehabits();
    getSkippedhabits();
    getScore();
    let addHabitModal  = document.getElementById('addHabit')

    addHabitModal.addEventListener('show.bs.modal', function (event) {
        let modalBodyInput = addHabitModal.querySelector('.modal-body input')
        modalBodyInput.value = ''
    })


    function selectDate(date) {

        $('.calendar-container').updateCalendarOptions({
            date: date
        });

        var dt = new Date(date);
        var choosedDate = dt.toISOString().split('T')[0]
        var today = new Date().toISOString().split('T')[0]

        getScore();


        var jsServerDate = new Date(serverDate).toISOString().split('T')[0];

        if(jsServerDate === choosedDate){
            dateTxt.innerHTML = "Today";
            getPendingHabits(serverDate);
        } else {
            let momtDateTxt = moment(choosedDate).fromNow();
            dateTxt.innerHTML = momtDateTxt;
            getPendingHabits(choosedDate);
        }
        getCompletehabits(choosedDate);
        getSkippedhabits(choosedDate);

    }

    var defaultConfig = {
        weekDayLength: 1,
        date: new Date(),
        onClickDate: selectDate,
        showYearDropdown: true,
        disable:function (date) {
            return date > new Date();
        }

    };

     $('.calendar-container').calendar(defaultConfig);

     $(document).on("click",".editIcon",function(e){
         let elem = $(this).parent().prev(".editContainer");
         elem.removeClass("knox lumos").addClass("lumos");

         let elem2 = $(this).parent();
         elem2.removeClass("knox lumos").addClass("knox");
     });

    $(document).on("click",".editBtn",function(e){
        let habitId = parseInt($(this).data("hbid"))
        let updatedHabitName = $(this).prev('input').val()
        let thisobj = this;
        $.ajax({
            url: './controller/habits/updateHabitName.php',
            data: {habit_id: habitId,habit_name:updatedHabitName},
            type: 'post',
            success: function(output) {
                toast.fire({
                    icon: 'success',
                    title: 'Habit name changed'
                }).then((result) => {

                })

                let elem = $(thisobj).parent();
                elem.removeClass("lumos knox").addClass("knox");

                let elem2 = $(thisobj).parent().parent().find("h6");
                elem2.removeClass("lumos knox").addClass("lumos");

                getPendingHabits();
                getCompletehabits();
                getSkippedhabits();
                getScore();

            },error: function (){
                alert("Unable to change habit name!")
            }
        });

    });


    $(document).on("click",".deleteBtn",function(e){
        let habitId = parseInt($(this).data("hbid"))

        $.ajax({
            url: './controller/habits/deleteHabit.php',
            data: {habit_id: habitId},
            type: 'post',
            success: function(output) {
                toast.fire({
                    icon: 'success',
                    title: 'Habit removed!'
                }).then((result) => {

                })
                getPendingHabits();
                getCompletehabits();
                getSkippedhabits();
                getScore();
            },error: function (){
                alert("Unable to change habit name!")
            }
        });

    });
    $(document).on("click",".cancelBtn",function(e){
        let elem = $(this).parent();
        elem.removeClass("lumos knox").addClass("knox");

        let elem2 = $(this).parent().parent().find('h6');
        elem2.removeClass("knox lumos").addClass("lumos");
    })

    $(document).on("click",".statBtn",function(e){
        var hbtId = $(this).data("hbid")
        location.href = "./stats.php?id="+hbtId
    })
});