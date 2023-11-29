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

    <style>
        .confirmed {
            background-color: green !important;
            color: white;
        }
    </style>
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
                    <a class="nav-link" href="#" style="font-size:18px;">Username | Birthday</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="font-size:18px;">Home</a>
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

                <table class="table table-bordered">
                    <tr class="table-success">
                        <?php
                        $dt = new DateTime('today'); // Set initial date to today
                        for ($i = 0; $i < 7; $i++) {
                            if ($dt->format('d M Y') == date('d M Y')) {
                                echo "<td style='background:yellow'>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</td>\n";
                            } else {
                                echo "<td>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</td>\n";
                            }

                            $dt->modify('+1 day');
                        }
                        ?>
                    </tr>
                    <?php
                    $dt = new DateTime('today'); // Reset $dt to today
                    $timeslots = timeslots($duration, $cleanup, $start, $end);
                    foreach ($timeslots as $ts) {
                    ?>
                        <tr>
                            <?php
                            for ($i = 0; $i < 7; $i++) {
                            ?>
                                <td><button class="btn btn-info btn-xs slot-btn" data-toggle="modal" data-target="#appointmentModal"><?php echo $ts; ?></button></td>
                            <?php
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

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Appointment</h5>
                </div>
                <div class="modal-body">
                    <p>Do you want to confirm this appointment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary confirm-appointment">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.slot-btn').click(function() {
                $('#appointmentModal').modal('show');
            });

            $('#appointmentModal').on('hidden.bs.modal', function(e) {
                // Check if 'Confirm' button was clicked
                if ($('.modal-footer .confirm-appointment').data('clicked')) {
                    $('.slot-btn:focus').addClass('confirmed');
                }
                // Reset the 'clicked' data attribute
                $('.modal-footer .confirm-appointment').data('clicked', false);
            });

            $('.modal-footer .btn-secondary').click(function() {
                $('#appointmentModal').modal('hide');
            });

            $('.modal-footer .confirm-appointment').click(function() {
                // Set 'clicked' data attribute to true
                $(this).data('clicked', true);
                $('#appointmentModal').modal('hide');
            });
        });
    </script>

</body>

</html>