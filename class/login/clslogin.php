<?php
class login
{
    public function connectlogin()
    {
        include_once __DIR__ . '/../../config.php';
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (!$con) {
            echo "Kết nối thất bại";
            exit();
        } else {
            mysqli_set_charset($con, "utf8");
            return $con;
        }
    }
    public function mylogin($user, $pass)
    {
        $pass = md5($pass);
        $link = $this->connectlogin();
        $sql = "select * from users where email= ? and matKhau= ? limit 1";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);
        $ketqua = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($ketqua) == 1) {
            while ($row = mysqli_fetch_array($ketqua)) {
                $id_user = htmlspecialchars($row['id_user']);
                $ten= htmlspecialchars($row['Ten']);
                $email = htmlspecialchars($row['email']);
                $matKhau = htmlspecialchars($row['matKhau']);
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['id_user'] = $id_user;
                $_SESSION['ten'] = $ten;
                $_SESSION['email'] = $email;
                $_SESSION['matKhau'] = $matKhau;
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function confirmlogin($user, $pass)
    {
        $link = $this->connectlogin();
        $sql = "select * from users where email= ? and matKhau= ? limit 1";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);
        $ketqua = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($ketqua) != 1) {
            header("location:../../index.php");
        }
    }
}
