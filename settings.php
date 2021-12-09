<?php
session_start();

if(!$_SESSION['id']){
    header('location:./index.php');
}

date_default_timezone_set('America/Toronto'); // EST

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
    <title>Settings &centerdot; TrackGoals | Habit tracker</title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/bootstrap-icons.css">
    <link rel="stylesheet" href="template/css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <a href="index.php" id="logo" class="col-md-8 mb-2 mb-md-0 text-dark text-decoration-none">
                <img src="template/images/logo.png" alt="TrackGoals">
                <span>TrackGoals</span>
            </a>

            <div id="extraBox" class="col-12 col-md-1">

                <div id="notifsBox">
                    <a href="./friends.php"><i class="bi bi-people-fill"></i></a>
                </div>

                <div id="scoreBox">
                    <span><i class="bi bi-trophy"></i></span>

                    <span id="score"></span>
                </div>

            </div>

            <div class="dropdown text-end col-md-1">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./template/images/default.png" style="border-radius: 50%;" id="profilePic" alt="<?php echo ucfirst($_SESSION['firstname']); ?>" width="32" height="32" class="rounded-circle">
                    <span> <?php echo ucfirst($_SESSION['firstname']); ?></span>
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php?logout=true">Log out</a></li>
                </ul>
            </div>
        </header>
    </div>

    <div class="container-fluid pt-3 pb-3">
        <div class="d-grid gap-2 resetBox" >
            <div id="leftSide" class="resetBox" style="min-height: 450px">
                <div>
                    <h3>Profile Settings</h3>
                    <hr>
                </div>
                <div id="pending" class="resetBox">
                    <div class="d-flex align-items-start resetBox">
                        <div class="nav flex-column nav-pills me-3 resetBox" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Personal Info</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Email</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Reset Password</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Change Profile pic</button>
                        </div>
                        <div class="tab-content resetBox w-50" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <div class="col-md-7 col-lg-8">
                                    <h4 class="mb-3">Personal Info</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-label">Name</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label" id="name"></label>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-label">Email</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label" id="infoEmail"></label>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-label">Joined on</label>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="form-label" id="joinedOn"></label>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade " id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                                <div class="col-md-7 col-lg-8">
                                    <h4 class="mb-3">Email Address</h4>
                                    <hr>
                                    <form action="#" validate>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Current Email</label>
                                            <input type="email" class="form-control" id="email" placeholder="" required>

                                        </div>

                                        <div class="col-12">
                                            <label for="newEmail" class="form-label">New Email</label>
                                            <input type="email" class="form-control" id="newEmail" placeholder="" required>

                                        </div>
                                        <br>
                                        <button class="w-100 btn btn-success btn-lg" id="changeEmailBtn">Change Email</button>
                                    </form>

                                </div>

                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <div class="col-md-7 col-lg-8">
                                    <h4 class="mb-3">Password</h4>
                                    <hr>
                                    <form action="#" validate>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Old Password</label>
                                            <input type="password" class="form-control" id="oldPass" placeholder="" required>

                                        </div>

                                        <div class="col-12">
                                            <label for="newEmail" class="form-label">New Email</label>
                                            <input type="password" class="form-control" id="newPass" placeholder="" required>

                                        </div>
                                        <br>
                                        <button class="w-100 btn btn-success btn-lg" id="changePassBtn">Reset Password</button>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="col-md-7 col-lg-8">
                                    <h4 class="mb-3">Password</h4>
                                    <hr>

                                    <form method="post" action="#" enctype='multipart/form-data'>

                                        <div class="col-12">
                                            <label for="formFile" class="form-label">Upload picture</label>
                                            <input class="form-control" type="file" id="file" name="file" required>

                                        </div>

                                        <br>
                                        <button class="w-100 btn btn-success btn-lg" id="changeProfPicBtn">Change Picture</button>
                                    </form>

                                </div>
                            </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="template/js/bootstrap.bundle.min.js"></script>
<script src="template/js/sweetalert2.all.min.js"></script>
<script src="template/js/moment.js"></script>
<script src="template/js/settings.js"></script>
</body>
</html>

