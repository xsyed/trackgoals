<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include_once('./template/favicon.php');?>
    <title>TrackGoals &centerdot; Login</title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/css/login.css" rel="stylesheet">
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
                <a href="login.php"  class="btn btn-success me-2">Login</a>
                <a href="index.php#signup"  class="btn btn-outline-success ">Sign-up</a>
            </div>
        </header>
    </div>
    <div class="row">
        <main class="form-signin text-center mt-5 mb-5 pt-3 pb-3">
            <form id="loginForm" method="post"  validate>
                <h1 class="h3 mb-3 fw-normal">Login</h1>

                <div class="form-floating mt-4 mb-3">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" validate>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" validate>
                    <label for="floatingPassword">Password</label>
                </div>
                <button class="w-100 btn btn-lg btn-success" type="submit" name="login">Log in</button>
            </form>
        </main>
    </div>
    <div class="row">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2021 TrackGoals, Inc</p>

            <a href="index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">

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
    const form = document.getElementById('loginForm');

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
        const response = await fetch('./controller/login.php',{
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
            location.href = "./home.php";
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
