<?php
session_start();

include './Model/homeBack.php';

if (isset($_POST['submit'])) {
    $_SESSION['message'] = "Booking Appointment Successfully";
    header("Location: $_SERVER[PHP_SELF]");
    exit();
}

$message = isset($_SESSION['message']) ? "<div class='alert alert-success'>{$_SESSION['message']}</div>" : null;
unset($_SESSION['message']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOS Clinic</title>
    <link rel="icon" type="image/x-icon" href="./View/favicon_io/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: lightgreen;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="navbar-collapse" id="navbarNav">
                <a href="#"><img src="./View/logomedical.jpg" class="rounded-circle" style="max-width: 50px; height: auto; margin-right:9px;"></a>
                <a class="navbar-brand" href="#">SOS Clinic</a>
            </div>
            <!-- <div class="navbar-collapse" id="navbarNav"> -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" style="font-size:18px;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="font-size:18px;">Username | <i class="fa fa-user"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=login" style="font-size:18px;">Sign in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=register" style="font-size:18px;">Sign up</a>
                </li>
            </ul>
            <!-- </div> -->
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center>
                    <br>
                    <h2>Clinical Appointment Options</h2>
                </center>
                <form id="doctor_select_form">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 form-group">
                            <label style="font-size: 17px;font-weight:semi-bold;margin-left:3px;margin-bottom:3px;"> Select your doctor :</label>

                            <select class="form-control" id="doctor_select" style="width: 200px;">
                                <option value="doctor1"></option>
                                <option value="doctor1">Doctor Goodbye</option>
                            </select>
                            <br>
                        </div>
                    </div>
                </form>
                <div class="col-md-12">
                    <?php echo isset($message) ? $message : ""; ?>
                </div>
                <table class="table table-bordered">
                    <tr class="table-success">
                        <?php
                        $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
                        $dt = new DateTime('today', $timezone);
                        $todayne = $dt->format('d M Y');
                        for ($i = 0; $i < 7; $i++) {
                            if ($dt->format('d M Y') == $todayne) {
                                echo "<td style='background:yellow'>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</td>\n";
                            } else {
                                echo "<td>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</td>\n";
                            }
                            $dt->modify('+1 day');
                        }
                        ?>
                    </tr>
                    <?php
                    $dt = new DateTime('today', $timezone);
                    $timeslots = timeslots($duration, $cleanup, $start, $end);
                    foreach ($timeslots as $ts) {
                    ?>
                        <tr>
                            <?php
                            $dt = new DateTime('today', $timezone);
                            for ($i = 0; $i < 7; $i++) {
                                if (checkExpire($ts) && ($dt->format('d M Y') == $todayne)) {
                            ?>
                                    <td><button class="btn btn-light btn-xs slot-btn" data-timeslot="<?php echo $ts;  ?>"><?php echo $ts;  ?></button></td>
                                <?php
                                } else {
                                ?>
                                    <td><button class="btn btn-info btn-xs slot-btn book" data-timeslot="<?php echo $ts;  ?>"><?php echo $ts;  ?></button></td>
                            <?php
                                }

                                $dt->modify('+1 day');
                            }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Booking Appointment Information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group mb-2">
                                    <label for="">Time</label>
                                    <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Patient</label>
                                    <input required type="text" readonly name="Patientname" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Email</label>
                                    <input required type="email" readonly name="email" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Doctor</label>
                                    <input required type="text" readonly name="Doctorname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="submit">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(".book").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");
        })
    </script>

</body>

</html>