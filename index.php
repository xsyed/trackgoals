<?php
session_start();

if(isset($_SESSION['id'])) {
        header('location:./home.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include_once('./template/favicon.php');?>
    <title>TrackGoals | Habit tracker</title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/bootstrap-icons.css">
    <link rel="stylesheet" href="template/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="index.php" id="logo" class="col-md-9 mb-2 mb-md-0 text-dark text-decoration-none">
                <img src="template/images/logo.png" alt="TrackGoals">
                <span>TrackGoals</span>
            </a>

            <div class="col-md-3 text-end">
                <a href="login.php"  class="btn btn-outline-success me-2">Login</a>
                <a href="#signup"  class="btn btn-success">Sign-up</a>
            </div>
        </header>
    </div>
    <div class="row">
        <div class="px-4 my-5 text-center border-bottom">
            <h1 class="display-6">Every day, it gets a little easier.<br>But you gotta do it every day, that's the hard part.</h1>
            <div class="col-lg-6 mx-auto">
                <p class="lead mb-4"></p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                    <a href="#signup" class="btn btn-outline-success btn-lg px-4">Track your habits</a>
                </div>
            </div>

            <div class="container px-5">
                <img src="template/images/demo.gif" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
            </div>

        </div>
    </div>
    <div class="row">
        <div class="container px-4 py-5" id="featured-3">
            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-6 fw-normal">Simple and beautiful habit tracker</h1>
                <p class="fs-5 text-muted">Form new habits to achieve your goals</p>
            </div>
            <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                <div class="feature col text-center">
                    <div class="feature-icon mb-4">
                        <i class="bi bi-droplet text-success fs-1"></i>
                    </div>

                    <h4 class="text-center">Do it every day</h4>
                    <p>Get disciplined. Doing it every day helps you form new habits, and habits are what make you reach your goals</p>

                </div>
                <div class="feature col text-center">
                    <div class="feature-icon mb-4">

                        <i class="bi bi-trophy text-success fs-1"></i>
                    </div>
                    <h4 class="text-center">Don't break the chain</h4>
                    <p>The more days you manage to chain in a row, the less likely you are to quit</p>

                </div>
                <div class="feature col text-center">
                    <div class="feature-icon mb-4">
                        <i class="bi bi-eye-fill text-success fs-1"></i>
                    </div>
                    <h4 class="text-center">Visualize your progress</h4>
                    <p>Have a quick overview of your goals and streaks in a single beautiful board</p>

                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-center g-lg-5 py-5" id="signup">

        <div class="col-lg-6 mx-auto">
            <div class="text-center">
                <h1 class="display-6 fw-bold lh-1 mb-3 text-success">Start tracking your habits!</h1>
                <p class="col-lg-10 fs-4">TrackGoals is Free.<br>Forever!</p>
            </div>
            <form class="p-4 p-md-5 border rounded-3 bg-light" id="registerForm" method="post"  validate>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingName" placeholder="Name" name="first_name" required>
                    <label for="floatingName">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>
                <button type="submit" class="w-100 btn btn-lg btn-success" name="register">Sign up</button>
                <hr class="my-4">
                <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
            </form>
        </div>
    </div>

    <div class="row">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2021 TrackGoals, Inc</p>

            <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">

                <img src="template/images/logo.png" alt="TrackGoals Logo" class="" width="50" height="50" />
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
<script src="template/js/bootstrap.bundle.min.js"></script>
<script src="template/js/sweetalert2.all.min.js"></script>
<script>

    const loginFailedToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    })

    // Get the whole form, not the individual input-fields
    const form = document.getElementById('registerForm');

    /**
     * Add an onclick-listener to the whole form, the callback-function
     * will always know what you have clicked and supply your function with
     * an event-object as first parameter, `addEventListener` creates this for us
     */
    form.addEventListener('submit', function(event){
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

    async function postData(formattedFormData){
        /**
         * If we want to 'POST' something we need to change the `method` to 'POST'
         * 'POST' also expects the request to send along values inside of `body`
         * so we must specify that property too. We use the earlier created
         * FormData()-object and just pass it along.
         */
        const response = await fetch('./controller/register.php',{
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
        if(data === "Success"){
            Swal.fire({
                title: 'Successfully registered!',
                text: "",
                icon: "success",
                confirmButtonColor: '#157347',
                confirmButtonText: 'Login'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "./login.php";
                }
            })

        } else {
            loginFailedToast.fire({
                icon: 'error',
                title: data
            })
        }

    }
</script>
</body>
</html>
