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
    <title>Statistic &centerdot; TrackGoals | Habit tracker</title>
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
                <div id="datediv">
                    <h3 id="habitTxt">Loading...</h3>
                    <br>
                </div>
                <div id="pending">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>

                </div>

            </div>
            <div class="bg-light border rounded-3" id="rightSide">
                <div class="w-100">
                    <h3 class="px-3 py-2 ">Stats</h3>

                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex py-3" aria-current="true">
                        <i class="bi bi-gem streakIcons rounded-circle flex-shrink-0 totalCheckin" ></i>
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-0">Total Checkins</h6>
                            <p class="mb-0 opacity-75" id="totalCheckin">0 days</p>
                        </div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action d-flex  py-3" aria-current="true">
                        <i class="bi bi-hourglass-split streakIcons currStreakIcon rounded-circle flex-shrink-0" ></i>
                        <div class="d-flex w-100 justify-content-between">

                                <h6 class="mb-0">Current Streak</h6>
                                <p class="mb-0 opacity-75" id="currStreak">0 days</p>


                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex  py-3" aria-current="true">
                        <i class="bi bi-check-circle-fill  streakIcons bestStreakIcon rounded-circle flex-shrink-0"></i>
                        <div class="d-flex w-100 justify-content-between">

                            <h6 class="mb-0">Best Streak</h6>
                            <p class="mb-0 opacity-75" id="bestStreak">0 days</p>

                        </div>
                    </a>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="template/js/stats.js"></script>
</body>
</html>

