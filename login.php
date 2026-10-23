<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Panel de Administración</title>
	<link href="css/styles.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
		crossorigin="anonymous"></script>
	<style>
		@import url("https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&amp;display=swap");

		body {
			font-family: "Sarabun", sans-serif;
			font-size: 16px;
			color: #606063;
		}

		body {
			background-image: url(../landing/images/back-rtf-grey.png);
			background-size: cover;
		}

		body:before {
			/*content: '';
				position: absolute;
				background-image: -webkit-gradient(linear, right top, left top, from(rgba(255, 0, 0, 0)), to(#0d032b));
				background-image: linear-gradient(to left, rgba(255, 0, 0, 0), #0d032b);
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
				*/
		}

		.card-header {
			background-color: #129fd6;
		}

		.btn-primary {
			background-color: #129fd6;
			color: #ffffff;
			padding: 15px 40px;
			border-radius: 30px;
			display: inline-block;
			border: 1px solid #ffffff;
		}

		.btn-primary:hover {
			background-color: #242424;
			border: 1px solid #242424;
		}
	</style>

</head>

<body>

	<div id="layoutAuthentication" style="min-width: 100vw;display: flex;flex-direction: row;min-height: 100vh;">
		<div id="layoutAuthentication_content" style="min-width: 100vw;min-height: 100vh;align-content: center;">
			<main>
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-5">
							<div class="card shadow-lg border-0 rounded-lg">
								<div class="card-header" style="background-color:#111c43">
									<div align="center">
										<img src="landing/images/logo-rtf-bco.png" style="height:70px" alt="logo" class="img-fluid">
									</div>
								</div>
								<div class="card-body">
									<script>

										if (navigator.onLine) {

											document.write('<form method="post"  action="checklogin.php">');

											document.write('<div class="form-group">');
											document.write('<label class="small mb-1" for="inputEmailAddress">Usuario</label>');
											document.write('<input type="text" name="username"  placeholder="Nombre Usuario" class="form-control py-4" id="inputEmailAddress">');
											document.write('</div>');

											document.write('<div class="form-group">');
											document.write('<label class="small mb-1" for="inputPassword">Contraseña</label>');
											document.write('<input type="password" name="password" class="form-control py-4" placeholder="Password" id="inputPassword">');
											document.write('</div>');

											document.write('<div align="center">');
											document.write('<input class="btn btn-primary" type="submit" name="Submit" value="ENTRAR">');
											document.write('</div>');

											document.write('</form>');


										} else {

											document.write('<form method="post" action="javascript:go();">');

											document.write('<div class="form-group">');
											document.write('<label class="small mb-1" for="username">Usuario</label>');
											document.write('<input id="username" type="text" name="username"  placeholder="Nombre Usuario" class="form-control py-4" >');
											document.write('</div>');

											document.write('<div class="form-group">');
											document.write('<label class="small mb-1" for="password">Contraseña</label>');
											document.write('<input id="password" type="password" name="password" class="form-control py-4" placeholder="Password">');
											document.write('</div>');

											document.write('<div align="center">');
											document.write('<input class="btn btn-primary" type="submit" name="Submit_entrar" value="ENTRAR">');
											document.write('</div>');

											document.write('</form>');


										}

									</script>



								</div>
								
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>

	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
		crossorigin="anonymous"></script>
	<script src="js/scripts.js"></script>

	<!-- scripts -->


	<!-- stats.js -->



	<script>
		function go() {
			var pass = localStorage.getItem('pass');
			var user = localStorage.getItem('user');
			var permisos = localStorage.getItem('permisos');


			var entrypass = document.getElementById('password').value;
			var entryuser = document.getElementById('username').value;
			if (pass === entrypass && user === entryuser) {
				window.location.assign("empresa.php?user=" + user + "&permisos=" + permisos);
			} else {
				alert("Nombre de Usuario o password incorrectos, inténtelo de nuevo..");
				window.location.assign("login.php");
			}
		}
	</script>

</body>

</html>