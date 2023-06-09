<?php
    include "includes/config.php";
	include "includes/funciones.php";
    
    session_start();

    if(!isset($_SESSION['idUser'])){
        header("Location: index.php");
    }
    $userName=$_SESSION['userName'];
    $fullName=$_SESSION['fullName'];
    $type_user=$_SESSION['type'];

    $mysqli = conectar();
    $res=$mysqli->query("SELECT name, position, exercise, file FROM data");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        <title>Exercises</title>
        <link rel="icon" href="assets/images/caduceus-symbol.png" type="image/x-icon">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="assets/demo/allv6.1.0.js" crossorigin="anonymous"></script>
        <script src="assets/demo/npm_chart.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="assets/demo/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <style>        
            .loading-overlay {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              display: flex;
              align-items: center;
              justify-content: center;
              z-index: 999;
              visibility: hidden;
              opacity: 0;
              transition: opacity 0.3s;
            }
        
            .loading-overlay.show {
              visibility: visible;
              opacity: 1;
            }
        
            .loading-spinner {
              border: 16px solid #f3f3f3;
              border-top: 16px solid #3498db;
              border-radius: 50%;
              width: 120px;
              height: 120px;
              animation: spin 2s linear infinite;
            }
        
            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }

            .justified-text {
                text-align: justify;
            }

            .narrow-input {
                width: 200px;
            }

        </style>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="main.php">Laparoscopic Trainer</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="main.php"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $userName;?>
                        <i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <?php if($type_user==1){?>
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><hr class="dropdown-divider" /></li>
                    <?php } ?>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="main.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="exercises.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Exercises
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $fullName; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Exercises</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="main.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Exercises</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa fa-exchange"></i>
                                Peg Transfer
                            </div>
                            <div class="card-body">
                                <p class="justified-text">
                                    This task consists of lifting each of six rubber rings from one peg with the dominant hand,
                                    transferring it to the non-dominant hand, and then placing it on a second peg on the opposite
                                    side of a board using the laparoscopic graspers. This task involves skills at bimanual
                                    manipulation, grasping, hand–eye coordination, and spatial perception.
                                </p>

                                <div style="text-align: center;">
                                    <img src="assets/images/Transfer.PNG" alt="Image description" width="300" height="200" class="img-fluid">
                                    <!--<video src="assets/images/PegTransfer.mp4" controls></video>-->
                                </div>

                                <div class="container">
                                    <form id="pegTransferForm" class="mt-3">
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="text" class="form-control narrow-input" id="pegTransferUsername" name="username" placeholder="<?php echo $fullName; ?>" value="<?php echo $fullName; ?>" required>
                                            <button type="button" class="btn btn-primary ms-2" data-toggle="modal" data-target="#confirmModal">Try Exercise</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="loading-overlay" id="pegTransferLoadingOverlay">
                                    <div class="loading-spinner"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa fa-scissors"></i>
                                Pattern Cutting
                            </div>
                            <div class="card-body">
                                <p class="justified-text">
                                    The participants cut a 4.5 cm circular pattern on a piece of 13x13 cm nonwoven fabric 
                                    stretched in a plastic base. Using the laparoscopic scissors in his/her dominant hand, 
                                    the participant cut the drawn circle as close as possible. The task ends when the circle
                                    is completely cut out and separated from the fabric. This exercise requires skills at 
                                    cutting, grasping, precision, and hand–eye coordination.
                                </p>

                                <div style="text-align: center;">
                                <img src="assets/images/Cut.PNG" alt="Image description" width="300" height="200" class="img-fluid">
                                </div>

                                <div class="container">
                                    <form id="patternCuttingForm" class="mt-3">
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="text" class="form-control narrow-input" id="patternCuttingUsername" name="username" placeholder="<?php echo $fullName; ?>" value="<?php echo $fullName; ?>" required>
                                            <button type="button" class="btn btn-primary ms-2" data-toggle="modal" data-target="#confirmModal2">Try Exercise</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="loading-overlay" id="patternCuttingLoadingOverlay">
                                    <div class="loading-spinner"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-link"></i>
                                Intracorporeal Knot Suture
                            </div>
                            <div class="card-body">
                                <p class="justified-text">
                                The tasks consists of grasping the suture needle with the laparoscopic needle driver, 
                                puncturing, and knotting a 12 cm long suture through two predefined points in a longitudinally
                                slit Penrose drain. The suture is tied using an intracorporeal knot technique. 
                                A 2–0 silk suture on a 26 mm taper needle is used. This task involves skills at needle 
                                manipulation, management of a silk suture, knot tying, and bimanual dexterity.
                                </p>

                                <div style="text-align: center;">
                                    <img src="assets/images/Suture.PNG" alt="Image description" width="300" height="200" class="img-fluid">
                                </div>

                                <div class="container">
                                    <form id="KnotSutureForm" class="mt-3">
                                        <div class="form-group d-flex justify-content-center">
                                            <input type="text" class="form-control narrow-input" id="KnotSutureUsername" name="username" placeholder="<?php echo $fullName; ?>" value="<?php echo $fullName; ?>" required>
                                            <button type="button" class="btn btn-primary ms-2" data-toggle="modal" data-target="#confirmModal3">Try Exercise</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="loading-overlay" id="KnotSutureLoadingOverlay">
                                    <div class="loading-spinner"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Modal 1  -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Exercise</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to try the Peg Transfer exercise?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="pegTransferForm" title="OK">OK</button>
                    </div>
                </div>
            </div>
        </div>
                
                <!-- Modal 2 -->
        <div class="modal fade" id="confirmModal2" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Exercise</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to try the Pattern Cutting exercise?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="patternCuttingForm" title="OK">OK</button>
                    </div>
                </div>
            </div>
        </div>

                <!-- Modal 3 -->
        <div class="modal fade" id="confirmModal3" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Exercise</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to try the Knot Suture exercise?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="KnotSutureForm" title="OK">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function handleSubmit(formId, loadingOverlayId, endpoint) {
                var form = document.getElementById(formId);
                var usernameInput = form.querySelector("input[name='username']");
                var username = usernameInput.value;

                var loadingOverlay = document.getElementById(loadingOverlayId);
                loadingOverlay.classList.add("show"); // Show the loading overlay

                var url = "http://127.0.0.1:8900/"+ endpoint +"?username=" + encodeURIComponent(username);
                console.log("Request URL:", url);
                
                fetch(url)
                    .then(function(response) {
                        console.log("Response of Fetch for " + formId + ":", response);
                        loadingOverlay.classList.remove("show"); // Hide the loading overlay
                    })
                    .catch(function(error) {
                        console.error("Error during Fetch for " + formId + ":", error);
                        loadingOverlay.classList.remove("show"); // Hide the loading overlay
                    });
            }

            document.getElementById("pegTransferForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                $('#confirmModal').modal('hide');
                handleSubmit("pegTransferForm", "pegTransferLoadingOverlay", "run_transferencia");
            });

            document.getElementById("patternCuttingForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                $('#confirmModal2').modal('hide');
                handleSubmit("patternCuttingForm", "patternCuttingLoadingOverlay", "run_corte");
            });

            document.getElementById("KnotSutureForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent form submission
                $('#confirmModal3').modal('hide');
                handleSubmit("KnotSutureForm", "KnotSutureLoadingOverlay", "run_sutura");
            });
        </script>

        <script src="js/scripts.js"></script>
    </body>
</html>
