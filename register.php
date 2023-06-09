<?php
    include "includes/config.php";
	include "includes/funciones.php";
    
    session_start();

    if(!isset($_SESSION['idUser'])){
        header("Location: index.php");
    }
    //$idUser=$_SESSION['idUser'];
    $userName=$_SESSION['userName'];
    $fullName=$_SESSION['fullName'];
    $type_user=$_SESSION['type'];

    /*
    if($type_user==1){
        $where="";
    }else{
        $where="WHERE idUser=$idUser";
    }
    */

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
    <title>Register - Admin</title>
    <link rel="icon" href="assets/images/caduceus-symbol.png" type="image/x-icon">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="assets/demo/jquery.min.js"></script>
    <script src="assets/demo/allv6.1.0.js" crossorigin="anonymous"></script>
</head>
<body class="bg-primary" style="background-image: url('images/bg-01.jpg');">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create User Account</h3></div>
                                <div class="card-body">
                                    <form id="registerForm" method="POST">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" type="text" placeholder="Enter your first name" name="firstName" />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" type="text" placeholder="Enter your last name" name="lastName" />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" type="username" placeholder="name@example.com" name="username" />
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" name="password" />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" name="confirmPassword" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" name="registro" class="btn btn-primary btn-block">Create Account</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="main.php">Return</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="assets/demo/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Handle form submission
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Validate form data
            var firstName = document.getElementById("inputFirstName").value;
            var lastName = document.getElementById("inputLastName").value;
            var userName = document.getElementById("inputUsername").value;
            var password = document.getElementById("inputPassword").value;
            var confirmPassword = document.getElementById("inputPasswordConfirm").value;

            // Check for empty fields
            if (!firstName || !lastName || !userName || !password || !confirmPassword) {
                showModal("Empty Fields", "Please fill in all the required fields.");
                return;
            }

            // Check for password mismatch
            if (password !== confirmPassword) {
                showModal("Password Mismatch", "Passwords do not match.");
                return;
            }

            // Submit the form if all validations pass
            this.submit();
        });

        // Function to show the modal
        function showModal(title, message) {
            var modalHtml = `
                <div class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>${message}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Append the modal HTML to the body
            document.body.insertAdjacentHTML("beforeend", modalHtml);

            // Show the modal
            $(".modal").modal("show");

            // Remove the modal from the DOM after it's hidden
            $(".modal").on("hidden.bs.modal", function() {
                $(this).remove();
            });
        }
    </script>
</body>
</html>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $fullName = $_POST["firstName"] . ' ' . $_POST["lastName"];
    echo "PHP Info" . $fullName;

    // Validate form data (you can add more validation if needed)
    if (empty($firstName) || empty($lastName) || empty($userName) || empty($password) || empty($confirmPassword)) {
        echo "All fields are required.";
    } elseif ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Connect to the database (replace host, username, password, and dbname with your database details)
        $conn = conectar();
        mysqli_query($conn, "INSERT INTO users (user, password, fullName, type) VALUES ('$userName','$password','$fullName', '2')"); 

        // Redirect the user to the login page or display a success message
        // redir("/EndoTrainer/main.php");
        // exit();
    }
}
?>
