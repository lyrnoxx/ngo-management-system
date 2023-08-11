<?php
    session_start();
    $sessionId = $_SESSION['id'] ?? '';
    $sessionRole = $_SESSION['role'] ?? '';
    if ( $sessionId && $sessionRole ) {
        header( "location:index.php" );
        die();
    }
    $id = $_REQUEST['id'] ?? 'dashboard';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets2/img/favicon.png" rel="icon">
  <link href="assets2/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets2/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets2/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets2/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets2/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets2/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body style="background-color:blue" >

  <main>
    <div class="container">
    <?php if ( 'register' != $id ) {?>
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container" >
          <div class="row justify-content-center" >
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center" style="width:500px">

              <div class="card mb-3">

                <div class="card-body">
                <div class="d-flex justify-content-center py-4" style="padding-bottom:0%">
                <a href="index.html" class="logo d-flex align-items-center w-auto" >
                  <img src="assets2/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NGO</span>
                </a>
              </div><!-- End Logo -->


                  <div class="pt-4 pb-2" style="padding-bottom:0%;margin-top:0%">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  </div>

                  <form class="row g-3 needs-validation" action="login_core.php" method="GET">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">

                        <input type="text" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <input type="hidden" name="action" value="login">
                            <?php if ( isset( $_REQUEST['error'] ) ) {
                                    echo "<h5 class='text-center' style='color:red;'>Email and Password does not match! </h5>";
                            }?>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="login.php?id=register">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>
      <?php }?>
      <?php if ( 'register' == $id ) {?>
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center" style="padding-top:0%">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center" style="width:600px">

              <div class="card mb-3">

                <div class="card-body">
                <div class="d-flex justify-content-center py-4" style="padding-bottom:0%">
                <a href="index.html" class="logo d-flex align-items-center w-auto" style="padding-bottom:0%">
                  <img src="assets2/img/logo.png" alt="">
                  <span class="d-none d-lg-block" style="padding-bottom:0%">NGO</span>
                </a>
              </div><!-- End Logo -->


                  <div class="pt-4 pb-2" style="padding-top:0%">
                    <h5 class="card-title text-center pb-0 fs-4" style="padding-top:0%">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" action="add.php" method="POST">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>

                    <div class="col-12">
                      <label for="phone" class="form-label">Phone</label>
                      <input type="tel" id="psw" name="phone" class="form-control" pattern="\d{10}" title="Must contain 10 digits" required>
                      <div class="invalid-feedback">Please, enter your phone number!</div>
                    </div>

                    <div class="col-12">
                      <label for="address" class="form-label">Address</label>
                      <input type="text" name="address" class="form-control" required>
                      <div class="invalid-feedback">Please, enter your address!</div>
                    </div>

                    <div class="col-12">
                      <label for="gender" class="form-label">Gender</label>
                      <select name="gender" class="form-select">
                        <option value="other" selected>Other</option>
                        <option value="male" >Male</option>
                        <option value="female" >Female</option>
                    </select>
                      <div class="invalid-feedback">Please, enter your gender!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" id="psw" name="password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <input type="hidden" name="action" value="addUser">
                            <?php if ( isset( $_REQUEST['error'] ) ) {
                                    echo "<h5 class='text-center' style='color:red;'>Email already exists!</h5>";
                            }?>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

        </section>
        <?php }?>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets2/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets2/vendor/chart.js/chart.umd.js"></script>
  <script src="assets2/vendor/echarts/echarts.min.js"></script>
  <script src="assets2/vendor/quill/quill.min.js"></script>
  <script src="assets2/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets2/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets2/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets2/js/main.js"></script>

</body>

</html>

