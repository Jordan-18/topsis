<?php
	session_start();
	require 'functions/Connection.php'; 
	// cek cookie
	if (isset($_COOKIE['id']) && isset($_COOKIE['key'])){
		$id = $_COOKIE['id'];
		$key = $_COOKIE['key'];

		// ambil username berdasarkan id
		$resu = mysqli_query($conn,"SELECT username FROM users WHERE id = $id");

		$row = mysqli_fetch_assoc($resu);


		// cek cookie
		if($key === hash('sha256', $row['username'])){
			$_SESSION['login'] = true;
		}

	}
	// cek session 
	if(isset($_SESSION["login"])){
		header("Location:index");
		exit;
	}


	if(isset($_POST["login"])){
		$username = $_POST["username"];
		$password = $_POST["password"];

		$result = mysqli_query($conn,"SELECT * FROM users WHERE username = '$username'");;

		if(mysqli_num_rows($result) === 1){
		// cek password
			$row =mysqli_fetch_assoc($result);
		if(password_verify($password, $row["password"])){
			// set session 
			$_SESSION["login"] = true;
			$_SESSION["username"] = $row["username"];
			$_SESSION["role"] = $row["role"];
			if (isset($_POST['remember'])){
				// buat cookie
				setcookie('id',$row['id'],time()+60);
				setcookie('key',password_hash($row['username'], PASSWORD_DEFAULT),time() + 60);

			}
			header("Location: index");
			exit;
			}
		}

		$error = true;
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="assets/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <form accept="" method="POST">
                                    <div class="card-body">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="username" type="text" placeholder="User Name" name="username"/>
                                                <label for="username">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="password"/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="remember" type="checkbox" value="" name="remember"/>
                                                <label class="form-check-label" for="remember">Remember Password</label>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary btn-block" name="login">Login</button></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a href="register">Need an account? Sign up!</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
