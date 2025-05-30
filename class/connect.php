<?php
class quanly
{
    public function connect()
    {
        // Đường dẫn tuyệt đối để tránh lỗi khi include từ nhiều vị trí khác nhau
        include_once __DIR__ . '/../config.php';
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($con->connect_error) {
            die("Kết nối thất bại: " . $con->connect_error);
        } else {
            $con->set_charset("utf8");
            return $con;
        }
    }
    // public function themxoasua($sql)
    // {
    //     $link=$this->connect();
    //     $result=mysqli_query($link,$sql);
    //     if($result>0)
    //     {
    //         return 1;
    //     }
    //     else
    //     {
    //         return 0;
    //     }
    // }
    public function themxoasua($sql, $params = [])
    {
        $link = $this->connect();

        // Chuẩn bị câu lệnh SQL để tránh SQL injection
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Ràng buộc các tham số nếu có
            if (!empty($params)) {
                // Xác định kiểu dữ liệu của các tham số (ví dụ, 'i' cho integer, 's' cho string)
                $types = str_repeat('s', count($params));  // 's' cho chuỗi (string)

                // Đảm bảo tham số là tham chiếu
                $params_refs = [];
                foreach ($params as $key => $value) {
                    $params_refs[$key] = &$params[$key];
                }

                // Liên kết các tham số vào câu lệnh chuẩn bị
                array_unshift($params_refs, $types); // Thêm kiểu dữ liệu vào đầu mảng
                //vd: $params_refs bây giờ là: ['ssi', &$params[0], &$params[1], &$params[2]]
                call_user_func_array([$stmt, 'bind_param'], $params_refs);
            }

            // Thực thi câu lệnh
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                return 1; // Thành công
            } else {
                // Trả về thông báo lỗi nếu câu lệnh không thực thi thành công
                $error = mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                return "Lỗi SQL: " . $error;
            }
        } else {
            // Trường hợp không thể chuẩn bị câu lệnh SQL
            return "Lỗi chuẩn bị câu lệnh: " . mysqli_error($link);
        }
    }

    // public function laycot($sql)
    // {
    //     $link = $this->connect();
    //     $result = mysqli_query($link, $sql);
    //     $giatri = '';
    //     if (mysqli_num_rows($result) > 0) {
    //         while ($row = mysqli_fetch_array($result)) {
    //             $gt = $row[0];
    //             $giatri = $gt;
    //         }
    //         return $giatri;
    //     }
    // }
    public function laycot($sql, $params = [])
    {
        $link = $this->connect();
        // Chuẩn bị câu lệnh SQL
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt === false) {
            echo "Lỗi chuẩn bị câu lệnh SQL: " . mysqli_error($link);
            return false;
        }

        // Nếu có tham số, liên kết tham số vào câu lệnh
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $refs = [];
            foreach ($params as $key => $value) {
                $refs[$key] = &$params[$key];
            }
            array_unshift($refs, $types);
            call_user_func_array([$stmt, 'bind_param'], $refs);
        }

        // Thực thi câu lệnh SQL
        $executeResult = mysqli_stmt_execute($stmt);
        if ($executeResult === false) {
            echo "Lỗi thực thi câu lệnh SQL: " . mysqli_stmt_error($stmt);
            return false;
        }

        // Lấy kết quả
        $result = mysqli_stmt_get_result($stmt);
        if ($result === false) {
            echo "Lỗi lấy kết quả: " . mysqli_error($link);
            return false;
        }

        // Trả về giá trị cột đầu tiên nếu có kết quả
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            return htmlspecialchars($row[0], ENT_QUOTES, 'UTF-8');  // Bảo vệ khỏi XSS khi hiển thị
        }

        return '';  // Trả về chuỗi rỗng nếu không có kết quả
    }
}
