<?php
session_start();
error_reporting(E_ALL & ~E_WARNING);
if (isset($_SESSION['email']) && isset($_SESSION['matKhau'])) {
    include("../../class/login/clslogin.php");
    $c = new login();
    $c->confirmlogin($_SESSION['email'], $_SESSION['matKhau']);
} else {
    header("location:../../index.php");
}
?>
<?php
    if(filter_var($_REQUEST['id_maTK'], FILTER_VALIDATE_INT) === false) {
        header("location:quanLyDanhMuc.php");
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
// giải mã url để lấy id_maTK
// $encoded_id = $_REQUEST['id_maTK'];
//$id_maTK = base64_decode($encoded_id);
$id_maTK = intval($_REQUEST['id_maTK']);
$tenloaiTK = $p->laycot("SELECT tenLoai FROM loaitaikhoan WHERE id_maTK=?", [$id_maTK]);
$moTa = $p->laycot("SELECT moTa FROM loaitaikhoan WHERE id_maTK=?", [$id_maTK]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- sweetalert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <form method="POST">
                <h2 align="center" style="padding: 20px 0px;">Chỉnh sửa thông tin</h2>

                <div class="form-group">
                    <label for="firstname" class="form-label"> Tên loại tài khoản <span style="color:red">*</span> </label>
                    <input type="text" name="txtten" id="txtten" class="form-control" value="<?php echo $tenloaiTK; ?>" />
                </div>
                <div class="form-group mt-3">
                    <label for="lastname" class="form-label"> Mô tả </label>
                    <textarea name="txtmota" id="txtmota" type="text" class="form-control"><?php echo $moTa; ?></textarea>
                </div>


                <div style="display: flex; margin-top: 30px; justify-content: center; gap: 20px;">
                    <a class="btn btn-danger" style="padding: 10px 20px;" href="quanLyDanhMuc.php">Hủy</a>
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="reset" value="Nhập lại" class="btn btn-warning"></input>
                    <input type="submit" name="nut" value="Lưu" style="padding: 10px 20px;" class="btn btn-primary"></input>
                </div>

                <?php
                if (isset($_POST['nut']) && $_POST['nut'] == "Lưu" && $_REQUEST['token'] == $token) {
                    if ($_POST['txtten'] == "") {
                        echo '<script>swal("Thất bại", "Vui lòng nhập thông tin bắt buộc", "error");</script>';
                    } else {
                        $txtten = $_REQUEST['txtten'];
                        $txtmota = $_REQUEST['txtmota'];

                        $sql = "UPDATE loaitaikhoan SET tenLoai='$txtten',moTa='$txtmota'
                    WHERE id_maTK=?";
                        $params = [$id_maTK];
                        $result = $p->themxoasua($sql, $params);
                        if ($result == 1) {
                            echo '<script>
                            swal("Thành công", "Chỉnh sửa thông tin thành công", "success").then(function(){
                                window.location="quanLyDanhMuc.php";
                            });
                            setTimeout(function() {
                                window.location.href = "quanLyDanhMuc.php";
                            }, 1500);
                        </script>';
                            unset($_SESSION['token']);
                        } else {
                            echo '<script>swal("Thất bại", "Chỉnh sửa thông tin thất bại", "error");</script>';
                        }
                    }
                } else if (isset($_POST['nut']) && $_POST['nut'] == "Lưu" && $_REQUEST['token'] != $token) {
                    echo '<script>swal("Thất bại", "Token không hợp lệ", "error");</script>';
                    unset($_SESSION['token']);
                }
                ?>

            </form>
        </div>
    </div>


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background-color: #001C40;
        }

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            max-width: 550px;
            width: 100%;
            background: white;
            padding: 40px;
            border-radius: 30px;
        }

        .formbold-input-flex {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .formbold-input-flex>div F {
            width: 50%;
        }

        .formbold-input-radio-wrapper {
            margin-bottom: 28px;
        }

        .formbold-radio-flex {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .formbold-radio-label {
            font-size: 14px;
            line-height: 24px;
            color: #07074D;
            position: relative;
            padding-left: 25px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .formbold-input-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .formbold-radio-checkmark {
            position: absolute;
            top: -1px;
            left: 0;
            height: 18px;
            width: 18px;
            background-color: #FFFFFF;
            border: 1px solid #DDE3EC;
            border-radius: 50%;
        }

        .formbold-radio-label .formbold-input-radio:checked~.formbold-radio-checkmark {
            background-color: #6A64F1;
        }

        .formbold-radio-checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .formbold-radio-label .formbold-input-radio:checked~.formbold-radio-checkmark:after {
            display: block;
        }

        .formbold-radio-label .formbold-radio-checkmark:after {
            top: 50%;
            left: 50%;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #FFFFFF;
            transform: translate(-50%, -50%);
        }

        .formbold-form-input {
            width: 100%;
            padding: 13px 22px;
            border-radius: 5px;
            border: 1px solid #DDE3EC;
            background: #FFFFFF;
            font-weight: 500;
            font-size: 16px;
            color: #07074D;
            outline: none;
            resize: none;
        }

        .formbold-form-input::placeholder {
            color: #536387;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-form-label {
            color: #07074D;
            font-size: 14px;
            line-height: 24px;
            display: block;
            margin-bottom: 10px;
        }

        .formbold-btn {
            text-align: center;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            padding: 14px 25px;
            border: none;
            font-weight: 500;
            background-color: #6A64F1;
            color: white;
            cursor: pointer;
            margin-top: 25px;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</body>
<script>
    // Lấy các phần tử
    const loaiTaiKhoanSelect = document.getElementById('exampleSelect2');
    const tenNHInput = document.getElementById('txttenNH');
    const maPinInput = document.getElementById('txtmaPin');


    // Xử lý sự kiện khi thay đổi giá trị
    loaiTaiKhoanSelect.addEventListener('change', function() {
        if (this.value === '<?php echo $p->laycot("SELECT id_maTK FROM loaitaikhoan WHERE tenLoai='Tài khoản ngân hàng'"); ?>') {
            // Nếu chọn "Tài khoản ngân hàng", kích hoạt các ô
            tenNHInput.readOnly = false;
            maPinInput.readOnly = false;
        } else {
            // Nếu chọn loại khác, vô hiệu hóa và xóa nội dung
            tenNHInput.readOnly = true;
            maPinInput.readOnly = true;
            tenNHInput.value = ''; // Xóa nội dung ô Tên Ngân hàng
            maPinInput.value = ''; // Xóa nội dung ô Mã Pin
        }
    });

    // Gọi sự kiện change khi tải trang để thiết lập trạng thái ban đầu
    loaiTaiKhoanSelect.dispatchEvent(new Event('change'));
</script>

</html>