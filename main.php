<?php
    include "includes/config.php";
	include "includes/funciones.php";
    
    session_start();

    if(!isset($_SESSION['idUser'])){
        header("Location: index.php");
    }
    $idUser=$_SESSION['idUser'];
    $userName=$_SESSION['userName'];
    $fullName=$_SESSION['fullName'];
    $type_user=$_SESSION['type'];

    $mysqli = conectar();
    $res=$mysqli->query("SELECT name, position, exercise, file, img3d, maps FROM data");
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link rel="icon" href="assets/images/caduceus-symbol.png" type="image/x-icon">
        <link href="css/simple-datatable.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="assets/demo/allv6.1.0.js" crossorigin="anonymous"></script>
        <script src="assets/demo/npm_chart.js"></script>
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
                        <li><a class="dropdown-item" href="register.php">Register</a></li>
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
                        <h1 class="mt-4">Dashboard</h1>
                        
                        <div class="row">
                            <?php
                                $mysqli = conectar();
                                $maps_user=$mysqli->query("SELECT idData, name, position, exercise, file, img3d, maps FROM data WHERE userKey=".$idUser);
                                
                                $numRows = $maps_user->num_rows;

                                if ($numRows > 0) {
                                    echo '<div class="card-columns">';

                                    $counter = 1; // Counter for the ordered list
                                    
                                    while ($row = $maps_user->fetch_assoc()) {
                                        $data = $row['maps'];
                                        $name = $row['name'];
                                        $file = $row['file'];
                                        $img = $row['img3d'];
                                        $idData = $row['idData'];

                                        // Determine the value of $prueba based on $exercise
                                        $exercise = $row['exercise'];
                                        if ($exercise == 1) {
                                            $prueba = "Peg Transfer";
                                        } elseif ($exercise == 2) {
                                            $prueba = "Pattern Cutting";
                                        } elseif ($exercise == 3) {
                                            $prueba = "Intracorporeal Knot Suture";
                                        } else {
                                            $prueba = "Unknown Exercise";
                                        }
                                        
                                        // Generate Bootstrap card HTML for each row
                                        echo '<div class="card" style="max-width: 300px;">'; // Adjust the max-width value as per your requirement
                                        echo '<div class="card-body">';
                                        echo '<h5 class="card-title">' . $name . '</h5>';
                                        echo '<h6 class="card-subtitle mb-2 text-muted">' . $prueba . '</h6>';
                                        //echo '<p class="card-text">' . $data . '</p>';
                                        echo '<a href="results.php?idData=' . urlencode($idData) . '&idUser='.urlencode($idUser).'" class="btn btn-primary">Results</a>'; // Add your button markup with the link to results.php and the file parameter
                                        echo '</div>';
                                        echo '</div>';

                                        $counter++; // Increment the counter
                                    }
                                    
                                    echo '</div>'; // Close the card-columns div
                                } else {
                                    echo 'No rows found.';
                                }
                            ?>

                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="graphModal" tabindex="-1" aria-labelledby="graphModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="graphModalLabel">Boxplot Maps</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="chart-container">
                <!-- Chart content will be dynamically added here -->
                </div>
            </div>
            </div>
        </div>
        </div>

        <script src="assets/demo/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="assets/demo/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/simple-datatablesLatest.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-simple-demo.js"></script>
    </body>
</html>
