
<nav class="mb-1 navbar navbar-expand-lg hidden-sn grey-skin "	>
  <a class="navbar-brand black-text"  href="./">
    My Search App
  </a>
  <?php if (isset($pagina)){ ?>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  <?php } ?>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
		
		 <?php if (isset($pagina)){ ?>
      <li class="nav-item">
        <a class="nav-link waves-effect waves-light black-text" href="./">
           <i class="fas fa-edit fa-1x"></i> Load Token
        </a>
      </li>
		  <?php } ?>
		  <li class="dropdown dropdown-user">
        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
          <span class="user-name text-bold-600"><?php echo $_SESSION['username'] ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right nav-item">
          <a class="dropdown-item" href="./profile.php">
            <i class="feather icon-user"></i> Edit Profile
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" id="logoutBtn"><i class="feather icon-power"></i> Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<script type="text/javascript">
  $("#logoutBtn").click(function(e) {
    $.ajax({url: "logout.php", success: function(result){
      if (result == "success") {
        console.log("logout");
        document.location.href = "./index.php";
      } else {
        console.log("fail");
      }
      
    }});
  })
</script>
