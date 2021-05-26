<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION["username"])) {
  include_once( "funcoes.php" );
  include_once( "dbconfig.php" );
  $DBConfig = new DBConfig();
  $pg_connect = $DBConfig->pg_connect();

  $username = $_SESSION["username"];
  $password = '';
  $token = '';
  $result = pg_query($pg_connect,"SELECT * FROM tbl_user WHERE username='$username'");
  if (pg_num_rows($result) == 0)
  {
    echo "<script>alert('Invalid User');</script>";
  } else {
    while($row = pg_fetch_array($result))
    {
     $password = $row['password'];
     $token = $row['token'];
    }
  }
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

<body>
    <!-- BEGIN: Content-->
    <nav class="mb-2 navbar navbar-expand-lg hidden-sn grey-skin "  >
      <a class="navbar-brand black-text"  href="./main.php">
        My Search App
      </a>
    </nav>
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="row flexbox-container">
                    <div class="col-xl-9 col-11 justify-content-center">
                        <div class="card bg-authentication rounded-0 mb-0">
                            <div class="row m-0">
                                <div class="col-lg-12 d-lg-block d-none text-center align-self-center px-1 py-0">
                                    <div class="card rounded-0 mb-0 px-2">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="mb-0">User Profile</h4>
                                                <span>&nbsp;</span>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body pt-1">
                                                <form method="POST" action="">
                                                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                                                        <input type="email" class="form-control" id="user-name" name="user-name" value="<?=$username ?>" readonly>
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <label for="user-name">Email</label>
                                                    </fieldset>

                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="user-password" name="user-password" placeholder="Current Password">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="user-password">Current Password</label>
                                                    </fieldset>
                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="new-password" name="new-password" placeholder="New Password">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="new-password">New Password</label>
                                                    </fieldset>
                                                    <fieldset class="form-label-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-lock"></i>
                                                        </div>
                                                        <label for="confirm-password">Confirm Password</label>
                                                    </fieldset>
                                                    <div class="row">
                                                      <div class="col-xl-10 col-8">
                                                        <fieldset class="form-label-group position-relative has-icon-left">
                                                            <input type="text" class="form-control" id="usertoken" name="usertoken" value="<?php if (isset($_POST['usertoken'])) {echo $_POST['usertoken'];} else {echo $token;} ?>" readonly>
                                                            <div class="form-control-position">
                                                                <i class="feather icon-lock"></i>
                                                            </div>
                                                            <label for="confirm-password">Token</label>
                                                        </fieldset>
                                                      </div>
                                                      <div class="col-xl-2 col-3">
                                                        <button class="btn btn-default btn-sm float-right" id="genTokenBtn">Generate Token</button>
                                                      </div>
                                                    </div>
                                                    <button class="btn btn-primary" id="saveProfileBtn">Save</button>
                                                    <button class="btn btn-danger" id="cancelBtn">Cancel</button>

                                                    <?php
                                                      if (isset($_POST['user-password'])) {
                                                        $current_password = $_POST['user-password'];
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

                                                      if (isset($_POST['user-password'])) {
                                                        if ($password == $current_password && $new_password != "" && $confirm_password != "" && $new_password == $confirm_password) {
                                                          $result = pg_query($pg_connect,"UPDATE tbl_user SET token='$usertoken', password='$new_password' WHERE username='$username'");
                                                          $_SESSION["username"] = $username;
                                                          echo "<script>document.location.href='main.php';</script>";
                                                        }
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
      $("#genTokenBtn").click(function(e) {
        e.preventDefault();
        $.ajax({url: "gentoken.php", success: function(result){
          $("#usertoken").val(result);
        }});
      });
      $("#cancelBtn").click(function(e) {
        e.preventDefault();
        document.location.href = "./main.php";
      });
    });
  </script>

  <!-- Controllers -->
  <?php
    $DBConfig->pg_close($pg_connect);
  ?>
</body>

</html>
<?php
} else {
  echo "<script>alert('Access is denied');</script>";
  echo "<script>document.location.href='index.php';</script>";
}
?>