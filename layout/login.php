<?php
session_start();
session_destroy();
 ?>

<body class="login-page">
  <div class="wrapper wrapper-full-page ">
    <div class="full-page">
      <div class="content pd-t-0">
        <div class="text-center"><img
            src="img/schoollogo.png"
            alt="logo" class="login-logo" /></div>
        <div class="container mg-t-50">
          <div class="col-lg-6 col-md-6 ml-auto mr-auto">
            <form class="form" method="POST" action="ajax_php/a.login.php">
              <div class="card card-login login-card-border">
                <div class="card-header">
                  <div class="card-header">

                    <h3 class="header text-center login-title">Bodwell Parent Portal</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-single-02"></i>
                      </span>
                    </div>
                    <input id="userID" type="text" class="form-control" value="<?=$_POST['log']?>"
                      placeholder="Username">
                  </div>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="nc-icon nc-key-25"></i>
                      </span>
                    </div>
                    <input id="userPW" type="password" value="<?=$_POST['pwd']?>" placeholder="Password"
                      class="form-control">
                  </div>
                </div>
                <div class="card-footer ">
                  <a id="userLoginBtn" class="btn btn-warning btn-round btn-block mb-3">Login</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                ©
                <script>
                  document.write(new Date().getFullYear())
                </script>, Bodwell High School. All rights reserved. v1.0.6
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
      $("#userLoginBtn").click(function () {
        ajaxtologin();
      });

      $('#userPW').keypress(function (e) {
        var key = e.which;
        if (key == 13) // the enter key code
        {
          $('#userLoginBtn').click();
          return false;
        }
      });

    });
  </script>
