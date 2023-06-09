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

    $idData = $_GET['idData'];
    $idUser = $_GET['idUser'];
    
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
        <script src="assets/demo/plotly-latest.min.js"></script>
        
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
                                $maps_user=$mysqli->query("SELECT name, position, exercise, file, img3d, maps FROM data WHERE userKey=".$idUser." AND idData=".$idData);
                                $row = $maps_user->fetch_assoc();
                                $data = $row['maps'];
                                $name = $row['name'];
                                $file = $row['file'];
                                $img = $row['img3d'];
                            ?>

                            <table class="table">
                            <thead>
                                <tr>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="data-container-maps">
                            </tbody>
                            </table>

                            <script>
                                var data = <?php echo json_encode($data); ?>;
                                data = JSON.parse(data);

                                // Get the reference to the table body
                                var tableBody = document.getElementById("data-container-maps");

                                // Loop through the data object and create table rows with cells for each key-value pair.
                                var index = 0;
                                for (const [key, value] of Object.entries(data)) {
                                index++;
                                // Skip the first and tenth keys
                                if (index === 1 || index === 10) {
                                    continue;
                                }
                                const row = document.createElement("tr");

                                // Create the key cell
                                const keyCell = document.createElement("td");
                                keyCell.textContent = key;
                                row.appendChild(keyCell);

                                // Create the value cell
                                const valueCell = document.createElement("td");
                                // Check if the value is an array
                                if (Array.isArray(value)) {
                                    valueCell.textContent = value.join(", ");
                                } else {
                                    valueCell.textContent = value;
                                }
                                row.appendChild(valueCell);

                                // Create the graph button cell
                                const graphButtonCell = document.createElement("td");
                                const graphButton = document.createElement("button");
                                graphButton.textContent = "See Graph";
                                graphButton.classList.add("btn", "btn-primary");
                                graphButtonCell.appendChild(graphButton);
                                row.appendChild(graphButtonCell);

                                // Add event listener to the graph button
                                graphButton.addEventListener("click", function() {
                                    // Get the modal element
                                    var modal = document.getElementById("graphModal");

                                    // Get the chart container element inside the modal
                                    var chartContainer = modal.querySelector("#chart-container");

                                    // Clear the previous content of the chart container
                                    chartContainer.innerHTML = "";

                                    // Create a new chartBoxPlot div with a unique ID
                                    var chartBoxPlotDiv = document.createElement("div");
                                    var chartBoxPlotId = "chartBoxPlot_" + key; // Use the key to create a unique ID
                                    chartBoxPlotDiv.id = chartBoxPlotId;
                                    chartContainer.appendChild(chartBoxPlotDiv);

                                    // Open the modal
                                    var bsModal = new bootstrap.Modal(modal);
                                    bsModal.show();

                                    // Call the createBoxPlot function with the appropriate parameters
                                    createBoxPlot(<?php echo json_encode($name); ?>, key, value, chartBoxPlotId);
                                });

                                // Append the row to the table
                                tableBody.appendChild(row);
                                }

                            </script>
                            
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fas fa-chart-line me-1"></i>
                                    Pinza derecha 
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart1"></canvas>
                                        <script src="js/scripts.js"></script>
                                        <script>
                                            create_chartRight("assets/data/<?php echo $file; ?>", "myChart1");
                                        </script>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fas fa-chart-line me-1"></i>
                                    Pinza izquierda 
                                    </div>
                                    <div class="card-body">
                                    <canvas id="myChart2"></canvas>
                                    <script src="js/scripts.js"></script>
                                    <script>
                                        create_chartLeft("assets/data/<?php echo $file; ?>", "myChart2");
                                    </script>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                    <i class="fas fa-chart-line me-1"></i>
                                    Gráfica 3D de movimientos durante ejercicio
                                    </div>
                                    <div class="card-body">
                                    <div style="text-align: center;">
                                        <img src="assets/Graph3D/<?php echo $img; ?>" alt="Image description" class="img-fluid">
                                    <!--<video src="assets/images/PegTransfer.mp4" controls></video>-->
                                    </div>
                                    </div>
                                </div>
                            </div>

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
