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
    <title>Home &centerdot; TrackGoals | Habit tracker</title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template/css/bootstrap-icons.css">
    <link rel="stylesheet" href="template/css/calendar.css">
    <link rel="stylesheet" href="template/css/calendartheme.css">

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
                    <li><a class="dropdown-item" href="./settings.php">Settings</a></li>
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
                    <h3 id="dateTxt"><i class="bi bi-hourglass-split"></i> Today</h3>
                    <br>
                </div>
                <div id="pending">
                    <h5>TODO <i class="bi bi-watch"></i></h5>
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
                    <h5>Done  <i class="bi bi-check-circle-fill"></i></h5>
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
                    <h5>Skipped <i class="bi bi-flag-fill"></i></h5>
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
                <button type="button" class="btn btn-success w-100 mb-3" data-bs-toggle="modal" data-bs-target="#addHabit" >
                    <i class="bi bi-plus-circle"></i> Add Habit
                </button>

                <!-- Add Modal -->
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
                                        <label for="floatingInput">Habit Name</label>
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
                <!-- Edit Modal-->
                <div class="modal fade" id="editHabit" tabindex="-1" aria-labelledby="editHabitLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="fw-bold mb-0" id="editHabitLabel">Edit Habit</h2>
                            </div>
                            <form class="" id="editHabitForm" method="post" validate>
                                <div class="modal-body">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control rounded-4" name="habit_name" id="editHabitModal" placeholder="eg:Run 3kms" required>
                                        <label for="floatingInput">Edit Habit</label>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <input type="hidden" name="userId" value="<?php echo ucfirst($_SESSION['id']);?>" />
                                    <button class="btn btn-success" type="submit" data-bs-dismiss="modal"
                                    >Edit habit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <br>
                <div class="calendar-container"></div>
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
<script src="template/js/calendar.min.js"></script>
<script src="template/js/moment.js"></script>
<script src="template/js/main.js"></script>
</body>
</html>

