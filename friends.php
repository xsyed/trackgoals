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
    <title>Friends &centerdot; TrackGoals | Habit tracker</title>
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
                    <img src="./template/images/default.png" id="profilePic" alt="<?php echo ucfirst($_SESSION['firstname']); ?>" width="32" height="32" class="rounded-circle">
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

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friendsBox" type="button" role="tab" aria-controls="Friends" aria-selected="true">Friends <span class="badge rounded-pill bg-success" id="friendsCount">0</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requestsBox" type="button" role="tab" aria-controls="Requests" aria-selected="false">Requests <span class="badge rounded-pill bg-primary" id="requestCount">0</span></button>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="friendsBox" role="tabpanel" aria-labelledby="friend-tab">
                            <div class="row" id="friendsContent">


                            </div>
                        </div>
                        <div class="tab-pane fade" id="requestsBox" role="tabpanel" aria-labelledby="requests-tab">
                            <div class="row" id="friendsRequests">

                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="bg-light border rounded-3 py-1" id="rightSide" style="height: 300px">
                <div class="w-100">
                    <h4 class="px-3 py-2 ">Search Friend</h4>
                </div>
                <form action="search.php" method="get" class="row gx-3 gy-2 align-items-center" validate>
                    <div class="col-sm-9 py-2">
                        <label class="visually-hidden" for="specificSizeInputName">Name</label>
                        <input type="text" class="form-control" name="searchQuery" id="specificSizeInputName" placeholder="Search by Firstname" required>
                    </div>
                    <div class="col-auto py-2">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </form>
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
<script src="template/js/friends.js"></script>
</body>
</html>

