<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['matKhau'])) {
  include("../../class/login/clslogin.php");
  $c = new login();
  $c->confirmlogin($_SESSION['email'], $_SESSION['matKhau']);
} else {
  header("location:../../index.php");
}
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
<?php
include '../../class/xuLyDuLieu.php';
$p = new xuLyDuLieu();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thêm danh mục</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
  <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
</head>

<body class="app sidebar-mini rtl">
  <style>
    .Choicefile {
      display: block;
      background: #14142B;
      border: 1px solid #fff;
      color: #fff;
      width: 150px;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      padding: 5px 0px;
      border-radius: 5px;
      font-weight: 500;
      align-items: center;
      justify-content: center;
    }

    .Choicefile:hover {
      text-decoration: none;
      color: white;
    }

    #uploadfile,
    .removeimg {
      display: none;
    }

    #thumbbox {
      position: relative;
      width: 100%;
      margin-bottom: 20px;
    }

    .removeimg {
      height: 25px;
      position: absolute;
      background-repeat: no-repeat;
      top: 5px;
      left: 5px;
      background-size: 25px;
      width: 25px;
      /* border: 3px solid red; */
      border-radius: 50%;

    }

    .removeimg::before {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
      content: '';
      border: 1px solid red;
      background: red;
      text-align: center;
      display: block;
      margin-top: 11px;
      transform: rotate(45deg);
    }

    .removeimg::after {
      /* color: #FFF; */
      /* background-color: #DC403B; */
      content: '';
      background: red;
      border: 1px solid red;
      text-align: center;
      display: block;
      transform: rotate(-45deg);
      margin-top: -2px;
    }
  </style>
  <!-- Navbar-->
  <header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li><a class="app-nav__item" href="/index.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

      </li>
    </ul>
  </header>
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user"><a href="index.php"><img class="app-sidebar__user-avatar" src="../../main/img/login/login.jpg" width="50px"
          alt="User Image"></a>
      <div>
        <p class="app-sidebar__user-name"><b><?php echo $_SESSION['ten'] ?></b></p>
        <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item" href="index.php"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label">Quản lý tài khoản</span></a></li>
      <li><a class="app-menu__item" href="quanLyDanhMuc.php"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label">Quản lý danh mục</span></a></li>
      <li><a class="app-menu__item" href="Account.php"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Account</span></a></li>
    </ul>
  </aside>
  <main class="app-content">
    <div class="app-title">
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">Quản lý danh mục</li>
        <li class="breadcrumb-item"><a href="#">Thêm danh mục</a></li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Tạo mới danh mục ( Loại tài khoản mới )</h3>
          <div class="tile-body">
            <form class="row" method="POST">
              <div class="form-group col-md-6">
                <label class="control-label">Tên loại tài khoản <span style="color:red">*</span></label>
                <input class="form-control" type="text" pattern="^[A-Za-zÀ-Ỹà-ỹ\s]+$" title="Không được chứa số" name="txttenloai" id="txttenloai" placeholder="Nhập tên (Gmail, facebook,...)" required>
              </div>
              <div class="form-group col-md-6">
                <label class="control-label">Mô tả ( Nếu có )</label>
                <input class="form-control" type="text" name="txtmota" id="txtmota" placeholder="Nhập mô tả">
              </div>

              <div class="form-group col-md-12" align="center">
                <a class="btn btn-cancel" href="quanLyDanhMuc.php">Hủy</a>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="reset" value="Nhập lại" class="btn btn-warning"></input>
                <input class="btn btn-save" name="nut" value="Lưu" type="submit"></input>
              </div>

              <!-- Xử lý php -->
              <?php
              if (isset($_REQUEST['nut']) && $_REQUEST['nut'] == "Lưu" && $_REQUEST['token'] == $token) {
                $txttenloai = $_REQUEST['txttenloai'];
                $txtmota = $_REQUEST['txtmota'];
                if ($txttenloai == "") {
                  echo '<script>
                              swal("Thông báo", "Vui lòng nhập thông tin bắt buộc", "error");
                          </script>';
                } else if ($p->checkTenDanhMuc("select * from loaitaikhoan where tenLoai ='$txttenloai'") == 0) {
                  echo '<script>
                              swal("Thông báo", "Tên loại tài khoản đã tồn tại", "error");
                          </script>';
                } else {
                  $sql = "INSERT INTO loaitaikhoan(tenLoai,moTa) VALUES(?,?)";
                  $params = [$txttenloai, $txtmota];
                  $ketqua = $p->themxoasua($sql, $params);
                  if ($ketqua == 1) {
                    echo '<script>
                              swal("Thông báo", "Thêm danh mục mới thành công", "success").then(function(){
                              window.location="quanLyDanhMuc.php";
                              });
                              setTimeout(function() {
                                  window.location.href = "quanLyDanhMuc.php";
                              }, 1500);
                          </script>';
                    unset($_SESSION['token']);
                  } else {
                    echo '<script>
                                swal("Thông báo", "Thêm tài khoản thất bại", "error");
                            </script>';
                  }
                }
              } else if (isset($_REQUEST['nut']) && $_REQUEST['nut'] == "Lưu" && $_REQUEST['token'] != $token) {
                echo '<script>
                            swal("Thông báo", "Token không hợp lệ", "error");
                        </script>';
                unset($_SESSION['token']);
              }

              ?>
            </form>
          </div>

        </div>
  </main>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="../js/main.js"></script>


</body>

</html>