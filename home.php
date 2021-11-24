<?php
session_start();

if(!$_SESSION['id']){
    header('location:./index.php');
}

date_default_timezone_set('America/New_York'); // EST

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];

$currDate = "$year-$month-$date";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include_once('./template/favicon.php');?>
    <title>Home &centerdot; TrackGoals | Habit tracker</title>
    <link href="./template/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./template/css/bootstrap-icons.css">
    <link rel="stylesheet" href="./template/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="index.php" id="logo" class="col-md-8 mb-2 mb-md-0 text-dark text-decoration-none">
                <img src="./template/images/logo.png" alt="TrackGoals">
                <span>TrackGoals</span>
            </a>
            <form class="col-12 col-md-3 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control" placeholder="Search" aria-label="Search">
            </form>

            <div class="dropdown text-end col-md-1">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./template/images/<?php echo ucfirst($_SESSION['photo']); ?>" alt="<?php echo ucfirst($_SESSION['firstname']); ?>" width="32" height="32" class="rounded-circle">
                    <span> <?php echo ucfirst($_SESSION['firstname']); ?></span>
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Friends</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php?logout=true">Log out</a></li>
                </ul>
            </div>
        </header>
    </div>


    <div class="container-fluid pt-3 pb-3">
        <div class="d-grid gap-2" style="grid-template-columns: 3fr 1fr;">
            <div id="leftSide">
                <div id="pending">
                    <h2>TODO</h2>
                    <hr>
                    <div id="penhabits">

                        <div class="timeline-wrapper" id="habitloader">
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>


                        </div>

                        <div id="penhabitsWrap">

                        </div>

                    </div>
                </div>
                <div id="done">
                    <h2>Done</h2>
                    <hr>
                    <div id="donehabits">
                        <div class="timeline-wrapper" id="habitloaderCompleted">
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>


                        </div>

                        <div id="comphabitsWrap">

                        </div>
                    </div>
                </div>
                <div id="skip">
                    <h2>Skipped</h2>
                    <hr>
                    <div id="skippedHabits">
                        <div class="timeline-wrapper" id="habitloaderSkipped">
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="animated-background">
                                    <div class="background-masker header-top"></div>
                                </div>
                            </div>


                        </div>

                        <div id="skiphabitsWrap">

                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light border rounded-3" id="rightSide">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addHabit" >
                    Add Habit
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addHabit" tabindex="-1" aria-labelledby="addHabitLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="fw-bold mb-0" id="addHabitLabel">New Habit</h2>
                            </div>
                            <form class="" id="addHabitForm" method="post" validate>
                                <div class="modal-body">


                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-4" name="habit_name" id="floatingInput" placeholder="eg:Run 3kms" required>
                                        <label for="floatingInput">Habit</label>
                                    </div>

                                    <div class="mb-3">
                                        <p class="btn btn-primary p-3"></p>
                                        <p class="btn btn-secondary p-3"></p>
                                        <p class="btn btn-success p-3"></p>
                                        <p class="btn btn-danger p-3"></p>
                                        <p class="btn btn-warning p-3"></p>
                                        <p class="btn btn-info p-3"></p>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <input type="hidden" name="userId" value="<?php echo ucfirst($_SESSION['id']);?>" />
                                    <button class="btn btn-success" type="submit" data-bs-dismiss="modal"
                                    >Add habit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="userId" value="<?php echo ucfirst($_SESSION['id']);?>" />
    <input type="hidden" id="currDate" value="<?php echo $currDate;?>" />

    <div class="row">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2021 TrackGoals, Inc</p>

            <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">

                <img src="./template/images/logo.png" alt="TrackGoals Logo" class="" width="50" height="50" />
            </a>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Contact</a></li>
            </ul>
        </footer>
    </div>
</div>
<script src="./template/js/bootstrap.bundle.min.js"></script>
<script src="./template/js/sweetalert2.all.min.js"></script>
<script>
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    (function () {

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
            } else {
                toast.fire({
                    icon: 'error',
                    title: data
                })
            }
        }


        async function getPendingHabits() {

            let userId = document.getElementById("userId").value;
            let currDate = document.getElementById("currDate").value;

            const response = await fetch('./controller/habits/getPendingHabits.php?userId=' + userId + '&onDate=' + currDate);

            habitloader.style.display = "block";
            const data = await response.json();

            habitloader.style.display = "none";

            let penhabitsWrap = document.getElementById("penhabitsWrap");
            penhabitsWrap.innerHTML = "";

            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {

                    let habitName = '<div class="habitname"><h4 class="alert-heading">' + data[i].name + '</h4></div>';

                    let outerDiv = document.createElement("div");
                    outerDiv.innerHTML = habitName;

                    let hbtdiv = document.createElement("div");
                    let classes = ['habitbuttons'];
                    hbtdiv.classList.add(...classes);

                    let skipBtn = document.createElement("button");
                    skipBtn.className = "skipbutton";
                    skipBtn.innerHTML = '<i class="bi bi-calendar2-minus"></i>';

                    skipBtn.onclick = function() { changeHabitStatus(data[i].habit_id,2);}

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

        async function getCompletehabits() {

            let userId = document.getElementById("userId").value;
            let currDate = document.getElementById("currDate").value;

            const response = await fetch('./controller/habits/getCompletedHabits.php?userId=' + userId + '&onDate=' + currDate);

            habitloaderCompleted.style.display = "block";
            const data = await response.json();

            habitloaderCompleted.style.display = "none";

            let comphabitsWrap = document.getElementById("comphabitsWrap");
            comphabitsWrap.innerHTML = "";

            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {

                    let habitName = '<div class="habitname"><h4 class="alert-heading">' + data[i].name + '</h4></div>';

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

        async function getSkippedhabits() {

            let userId = document.getElementById("userId").value;
            let currDate = document.getElementById("currDate").value;

            const response = await fetch('./controller/habits/getSkippedHabits.php?userId=' + userId + '&onDate=' + currDate);

            habitloaderSkipped.style.display = "block";
            const data = await response.json();

            habitloaderSkipped.style.display = "none";

            let skiphabitsWrap = document.getElementById("skiphabitsWrap");
            skiphabitsWrap.innerHTML = "";

            if(data.length > 0){
                for (let i = 0; i < data.length; i++) {

                    let habitName = '<div class="habitname"><h4 class="alert-heading">' + data[i].name + '</h4></div>';

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

                    doneBtn.innerHTML = '<i class="bi bi-calendar2-minus"></i>';

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

        let addHabitModal  = document.getElementById('addHabit')

        addHabitModal.addEventListener('show.bs.modal', function (event) {
            let modalBodyInput = addHabitModal.querySelector('.modal-body input')
            modalBodyInput.value = ''
        })

    })();

</script>
</body>
</html>

