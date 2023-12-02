<?php
include './Model/homeBack.php';
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
                <?php
                if (!isset($_SESSION['login'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=login" style="font-size:18px;">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=register" style="font-size:18px;">Sign up</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="font-size:18px;"><?php echo $_SESSION['fullName']; ?> | <i class="fa fa-user"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./Model/logout_processing.php" style="font-size:18px;">Logout</a>
                    </li>
                <?php } ?>
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
                    <br>
                </center>
                <?php
                if (isset($_SESSION['role'])) {
                    if (!($_SESSION['role'])) {
                        include("./Model/connectDB.php");
                        $query = "SELECT userID, fullName FROM users WHERE role = 1";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                ?>
                            <form id="doctor_select_form">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3 form-group">
                                        <label style="font-size: 17px; font-weight:semi-bold; margin-left:3px; margin-bottom:3px;">Select your doctor :</label>

                                        <select class="form-control" id="doctor_select" style="width: 200px;">
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['userID'] . '">' . $row['fullName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                    </div>
                                </div>
                            </form>
                <?php
                        }
                    }
                } ?>
                <div class="col-md-12">
                    <?php
                    if (isset($_SESSION['successful'])) {
                        if ($_SESSION['successful']) {
                            echo "<div class='alert alert-success'>Booking Appointment Successfully</div>";
                            $_SESSION['successful'] = false;
                        }
                    }
                    if (isset($_SESSION['sucful'])) {
                        if ($_SESSION['sucful']) {
                            echo "<div class='alert alert-success'>Set up Appointment Successfully</div>";
                            $_SESSION['sucful'] = false;
                        }
                    }
                    if (isset($_SESSION['delete'])) {
                        if ($_SESSION['delete']) {
                            echo "<div class='alert alert-danger'>Cancel Appointment Successfully</div>";
                            $_SESSION['delete'] = false;
                        }
                    }
                    ?>
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
                                $curdate = $dt->format('Y-m-d');
                                if (isset($_SESSION['login'])) {
                                    if (checkExpire($ts) && ($dt->format('d M Y') == $todayne)) {
                            ?>
                                        <td><button class="btn btn-light btn-xs slot-btn">Time Booking Expired</button></td>
                                        <?php
                                    } elseif (!checkTime($ts, $curdate)) {
                                        if ($_SESSION['role']) {
                                        ?>
                                            <td><button class="btn btn-light btn-xs slot-btn doctorSet" data-timeslot="<?php echo $ts; ?>" date-time="<?php echo $curdate; ?>"><?php echo $ts;  ?></button></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><button class="btn btn-light btn-xs slot-btn"><?php echo $ts;  ?></button></td>
                                            <?php }
                                    } elseif (checkTime($ts, $curdate)) {
                                        if ($_SESSION['role']) {
                                            if (checkMyappointment2($ts, $curdate)) { ?>
                                                <td><button class="btn btn-success btn-xs slot-btn doctorcancel" data-timeslot="<?php echo $ts; ?>" date-time="<?php echo $curdate; ?>" patient-name="<?php echo getPatientName($ts, $curdate); ?>">Your appointment</button></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td><button class="btn btn-info btn-xs slot-btn doctorcancel" data-timeslot="<?php echo $ts; ?>" date-time="<?php echo $curdate; ?>" patient-name="<?php echo getPatientName($ts, $curdate); ?>"><?php echo $ts;  ?></button></td>
                                            <?php }
                                        } else {
                                            if (checkMyappointment($ts, $curdate)) { ?>
                                                <td><button class="btn btn-success btn-xs slot-btn patientcancel" data-timeslot="<?php echo $ts; ?>" date-time="<?php echo $curdate; ?>">Your appointment</button></td>
                                            <?php
                                            } elseif (checkOccupiedAppointment($ts, $curdate)) { ?>
                                                <td><button class="btn btn-danger btn-xs slot-btn">Being Occupied</button></td>
                                            <?php } else {
                                            ?>
                                                <td><button class="btn btn-info btn-xs slot-btn book" data-timeslot="<?php echo $ts; ?>" date-time="<?php echo $curdate; ?>"><?php echo $ts;  ?></button></td>
                                        <?php
                                            }
                                        }
                                    }
                                } elseif (!isset($_SESSION['login'])) {
                                    if (checkExpire($ts) && ($dt->format('d M Y') == $todayne)) {
                                        ?>
                                        <td><button class="btn btn-light btn-xs slot-btn">Time Booking Expired</button></td>
                                    <?php
                                    } else {
                                    ?>
                                        <td><button class="Notice-Login btn btn-light btn-xs slot-btn"><?php echo $ts;  ?></button></td>
                            <?php    }
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
                    <h4 class="modal-title">Booking Appointment Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="../Model/appointmentBooking.php" method="post">
                                <div class="form-group mb-2">
                                    <label for="">Date</label>
                                    <input required type="text" readonly name="dateapp" id="dateapp" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Time</label>
                                    <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Patient</label>
                                    <input required type="text" readonly name="Patientname1" id="Patientname1" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Email</label>
                                    <input required type="email" readonly name="email" id="email" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Your Doctor</label>
                                    <input required type="text" readonly name="doctr" id="doctr" class="form-control">
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


    <div class="modal" id="DoctorModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Setting Appointment Confirmation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="../Model/appointmentAdding.php" method="post">
                                <div class="form-group mb-2">
                                    <label for="">Date</label>
                                    <input required type="text" readonly name="dateappoint" id="dateappoint" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Time</label>
                                    <input required type="text" readonly name="timeslotdoctor" id="timeslotdoctor" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""> From Doctor</label>
                                    <input required type="text" readonly name="Doctorinname" id="Doctorinname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="confirm">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="DoctorModal2">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Appointment Cancelation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="../Model/appointmentDoctorCancel.php" method="post">
                                <div class="form-group mb-2">
                                    <label for="">Date</label>
                                    <input required type="text" readonly name="dateappoint2" id="dateappoint2" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Time</label>
                                    <input required type="text" readonly name="timeslotdoctor2" id="timeslotdoctor2" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""> Dear Doctor</label>
                                    <input required type="text" readonly name="Doctorinname2" id="Doctorinname2" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""> You have patient</label>
                                    <input required type="text" readonly name="patientinname2" id="patientinname2" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Do you still want to cancel this appointment ?</label>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="confirm">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="NoticeModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Please sign in to make an appointment !</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">


                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Okey, I got it !</button>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="PatientModal2">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Appointment Cancelation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="../Model/appointmentPatientCancel.php" method="post">
                                <div class="form-group mb-2">
                                    <label for="">Date</label>
                                    <input required type="text" readonly name="appointdate" id="appointdate" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Time</label>
                                    <input required type="text" readonly name="timeslotpatient" id="timeslotpatient" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""> Dear</label>
                                    <input required type="text" readonly name="patientname" id="patientname" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for=""> Your Doctor</label>
                                    <input required type="text" readonly name="doctr2" id="doctr2" class="form-control">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="">Do you want to cancel this appointment ?</label>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="patientcancel">Confirm</button>
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
        //login notice

        $(".Notice-Login").click(function() {
            $("#NoticeModal").modal("show");
        });
        // patient
        $(".book").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            var date = $(this).attr('date-time');
            $("#dateapp").val(date);
            $("#timeslot").val(timeslot);
            $("#Patientname1").val("<?php if (isset($_SESSION['fullName'])) {
                                        echo $_SESSION['fullName'];
                                    } else echo "Not found"; ?> ");
            $("#email").val("<?php if (isset($_SESSION['email'])) {
                                    echo $_SESSION['email'];
                                } else echo "Not found"; ?> ");
            $("#doctr").val("Trinh Thu Thuy");
            $("#myModal").modal("show");
        })
        $(".patientcancel").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            var date = $(this).attr('date-time');
            $("#timeslotpatient").val(timeslot);
            $("#appointdate").val(date);
            $("#doctr2").val("Trinh Thu Thuy");
            $("#patientname").val("<?php if (isset($_SESSION['fullName'])) {
                                        echo $_SESSION['fullName'];
                                    } else echo "Not found"; ?> ");
            $("#PatientModal2").modal("show");
        })
        // doctor
        $(".doctorSet").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            var date = $(this).attr('date-time');
            $("#timeslotdoctor").val(timeslot);
            $("#dateappoint").val(date);
            $("#Doctorinname").val("<?php if (isset($_SESSION['fullName'])) {
                                        echo $_SESSION['fullName'];
                                    } else echo "Not found"; ?> ");
            $("#DoctorModal").modal("show");
        })
        $(".doctorcancel").click(function() {
            var timeslot = $(this).attr('data-timeslot');
            var date = $(this).attr('date-time');
            var pName = $(this).attr('patient-name');
            $("#timeslotdoctor2").val(timeslot);
            $("#dateappoint2").val(date);
            $("#Doctorinname2").val("<?php if (isset($_SESSION['fullName'])) {
                                            echo $_SESSION['fullName'];
                                        } else echo "Not found"; ?> ");
            $("#patientinname2").val(pName);
            $("#DoctorModal2").modal("show");
        })
    </script>
    <script>
        // JavaScript to handle the selection change and update the session variable
        $(document).ready(function() {
            $("#doctor_select").change(function() {
                var selectedDoctorID = $(this).val();
                <?php echo 'var sessionDoctorID = "' . session_id() . '";'; ?>
                $.ajax({
                    type: 'POST',
                    url: 'update_session.php', // Replace with the actual PHP file to handle the update
                    data: {
                        sessionID: sessionDoctorID,
                        doctorID: selectedDoctorID
                    },
                    success: function(response) {
                        // Handle the response if needed
                        console.log(response);
                        // Reload the page
                        location.reload();
                    }
                });
            });
        });
    </script>

</body>

</html>