<?php
include('class/login/clslogin.php');
$p = new login();
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = md5(uniqid(rand(), true));
}
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> Login </title>
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<link rel="stylesheet" type="text/css" href="main/css/login.css">
<!-- sweetalert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
  <div class="container">
    <div class="cover">
      <div class="front">
        <img src="main/img/login/login.jpg" width="1536" height="2048" alt="">
      </div>
    </div>
    <div class="forms">
      <div class="form-content">
        <div class="login-form">
          <div class="title">Login</div>
          <form method="POST">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="email" name="txtemail" id="txtemail" style="width: 350px;" placeholder="Nhập email của bạn" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="txtpass" id="txtpass" placeholder="Nhập mật khẩu" required>
              </div>

              <div class="button input-box">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="submit" name="nut" value="Sumbit">
              </div>

            </div>
            <?php
            $max_temp = 5;
            $lock_time = 10; // 5 phút
            $user = isset($_REQUEST['txtemail']) ? $_REQUEST['txtemail'] : '';
            if ($user && isset($_SESSION['lock_time'][$user]) && time() - $_SESSION['lock_time'][$user] < $lock_time) {
              echo "<script>swal('Thất bại','Tài khoản $user đã bị khóa. Vui lòng thử lại sau " . ($lock_time - (time() - $_SESSION['lock_time'][$user])) . " giây.','error');</script>";
              unset($_SESSION['login_attempts'][$user]);
            } else
            if (isset($_REQUEST['nut']) && $_REQUEST['nut'] == "Sumbit" && isset($_REQUEST['token']) && $_REQUEST['token'] == $token) {
              $user = $_REQUEST['txtemail'];
              $pass = $_REQUEST['txtpass'];
              if ($user != "" || $pass != "") {
                $con = $p->connectlogin();
                $stmt = $con->prepare("SELECT * FROM users WHERE email = ? limit 1");
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                  if ($p->mylogin($user, $pass) == 1) {
                    echo '<script>
                                    swal("Thành công", "Đăng nhập thành công", "success").then(function(){
                                    window.location="Admin/doc/index.php";
                                    });
                                    setTimeout(function() {
                                      window.location.href = "Admin/doc/index.php";
                                    }, 2000);
                                  </script>';
                    unset($_SESSION['token']);
                  } else {
                    $_SESSION['login_attempts'][$user] = isset($_SESSION['login_attempts'][$user]) ? $_SESSION['login_attempts'][$user] + 1 : 1;
                    // Nếu số lần thử vượt quá giới hạn, khóa tài khoản này
                    if ($_SESSION['login_attempts'][$user] >= $max_temp) {
                      $_SESSION['lock_time'][$user] = time();
                      echo "<script>swal('Thất bại','Quá nhiều lần thử sai. Tài khoản $user đã bị khóa.','error');</script>";
                    } else {
                      echo "<script>swal('Thất bại','Tên đăng nhập hoặc mật khẩu sai. Bạn còn " . ($max_temp - $_SESSION['login_attempts'][$user]) . " lần thử.','error');</script>";
                    }
                  }
                }
                else
                {
                  echo '<script>swal("Thất bại","Tài khoản không tồn tại !!!","error");</script>';
                }
              } else {
                echo '<script>
                              swal("Thất bại", "Vui lòng điền đầy đủ thông tin", "error");
                            </script>';
              }
            } else if (isset($_REQUEST['nut']) && $_REQUEST['nut'] == "Sumbit" && isset($_REQUEST['token']) && $_REQUEST['token'] != $token) {
              echo '<script>swal("Thất bại","Không gửi lại form cũ","error")</script>';
              unset($_SESSION['token']);
            }
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>