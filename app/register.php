<!DOCTYPE html>
<html lang="en">
<?php
session_start();

include_once( "dbconfig.php" );
$DBConfig = new DBConfig();
$pg_connect = $DBConfig->pg_connect();
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>My Search App</title>
  <!-- MDB icon -->
  <link rel="icon" href="./img/mdb-favicon.ico" type="image/x-icon">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="./css/bootstrap.min.css?r=<?php echo rand();?>">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="./css/mdb.min.css?r=<?php echo rand();?>">
  <!-- Other CSS -->
  <link rel="stylesheet" type="text/css" href="./css/bootstrap-extended.css?r=<?php echo rand();?>">
  <link rel="stylesheet" type="text/css" href="./css/vendors.min.css?r=<?php echo rand();?>">
  <link rel="stylesheet" href="./css/components.css?r=<?php echo rand();?>">
  <!-- Your custom styles (optional) -->
  <link rel="stylesheet" href="./css/style.css?r=<?php echo rand();?>">
  <!-- Jquery UI-->
  <link rel="stylesheet" href="./js/jquery-ui-1.12.1.custom/jquery-ui.css?r=<?php echo rand();?>">
  <!-- Jquery UI-->
</head>

<body class="horizontal-layout horizontal-menu 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-11 d-flex justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-4 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <img src="img/login.png" alt="branding logo">
                                </div>
                                <div class="col-lg-8 col-12 p-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">Register</h4>
                                            </div>
                                        </div>
                                        <p class="px-2"></p>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form method="POST" action="">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="email" class="form-control" id="user-email" name="user-email" placeholder="Email" value="<?php if(isset($_POST['user-email'])){echo $_POST['user-email'];} ?>" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-email">Email</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="user-name" name="user-name" placeholder="Username" value="<?php if(isset($_POST['user-name'])){echo $_POST['user-name'];}?>" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-name">Username</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Password" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="new-password">Password</label>
                                                    </fieldset>
                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="confirm-password">Confirm Password</label>
                                                    </fieldset>
                                                    <div class="row">
                                                      <div class="col-xl-9 col-8">
                                                        <fieldset class="form-label-group position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="usertoken" name="usertoken" readonly required>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <label for="confirm-password">Token</label>
                                                        </fieldset>
                                                      </div>
                                                      <div class="col-xl-3 col-3">
                                                        <button class="btn btn-default btn-sm float-right" id="genTokenBtn">Generate</button>
                                                      </div>
                                                    </div>
                                                    <button class="btn btn-primary" id="registerBtn">Register</button>
                                                    <button class="btn btn-danger" id="cancelBtn">Cancel</button>

                                                    <?php
                                                      
                                                      if (isset($_POST['user-email'])) {
                                                          $email = $_POST['user-email'];
                                                      }
                                                      if (isset($_POST['user-name'])) {
                                                          $username = $_POST['user-name'];
                                                      }
                                                      if (isset($_POST['new-password'])) {
                                                        $new_password = $_POST['new-password'];
                                                      }
                                                      if (isset($_POST['confirm-password'])) {
                                                        $confirm_password = $_POST['confirm-password'];
                                                      }
                                                      if (isset($_POST['usertoken'])) {
                                                        $usertoken = $_POST['usertoken'];
                                                      }

                                                      if (isset($_POST['user-email']) && isset($_POST['user-name']) && isset($_POST['new-password']) && isset($_POST['confirm-password']) && isset($_POST['usertoken']) && $_POST['new-password'] == $_POST['confirm-password']) {
                                                          $result = pg_query($pg_connect,"INSERT INTO tbl_user (username, email, password, token) VALUES ('$username', '$email', '$new_password', '$usertoken')");
                                                          echo "<script>document.location.href='index.php';</script>";
                                                      }
                                                      
                                                    ?>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="login-footer">
                                          <div class="divider"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->

  <!-- jQuery -->
  <script type="text/javascript" src="./js/jquery.min.js?r=<?php echo rand();?>"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="./js/mdb.min.js?r=<?php echo rand();?>"></script>
  <!-- Jquery UI -->
  <script>
    $(document).ready(function () {
      function genToken() {
        $.ajax({url: "gentoken.php?key=reg", success: function(result){
          $("#usertoken").val(result);
        }});
      }
      genToken();
      $("#genTokenBtn").click(function(e) {
        e.preventDefault();
        genToken();
      });
      $("#cancelBtn").click(function(e) {
        e.preventDefault();
        document.location.href = "./index.php";
      });
    });
  </script>

  <!-- Controllers -->
  <?php
    $DBConfig->pg_close($pg_connect);
  ?>
</body>

</html>