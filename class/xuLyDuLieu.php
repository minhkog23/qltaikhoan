<?php
    include 'connect.php';
    class xuLyDuLieu extends quanly
    {
        public function getTaiKhoan($sql)
        {
            $link=$this->connect();
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)>0)
            {
                echo '<thead>
                                <tr>
                                    <th style="text-align:center">STT</th>
                                    <th style="text-align:center">Tên tài khoản</th>
                                    <th style="text-align:center">Mật khẩu</th>
                                    <th style="text-align:center">Loại tài khoản</th>
                                    <th style="text-align:center">Tên ngân hàng ( Nếu có )</th>
                                    <th style="text-align:center">Mã Pin thẻ ( Nếu có ) </th>
                                    <th style="text-align:center">Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                ';
                $count=0;
                while($row=mysqli_fetch_array($result))
                {
                    $id_taiKhoan=htmlspecialchars($row['id_taiKhoan']);
                    $taiKhoan=htmlspecialchars($row['taiKhoan']);
                    $matKhau=htmlspecialchars($row['matKhau']);
                    $id_user=htmlspecialchars($row['id_user']);
                    $tenLoai=htmlspecialchars($row['tenLoai']);
                    $tenNganHang=htmlspecialchars($row['tenNganHang']);
                    $maPinThe=htmlspecialchars($row['maPinThe']);
                    $id_maTK=htmlspecialchars($row['id_maTK']);
                    $count++;
                    // mã hóa url id_taiKhoan
                    //$encoded_id=base64_encode($id_taiKhoan);
                    echo '
                    <tr>
                                    <td style="text-align:center">'.$count.'</td>
                                    <td style="text-align:center">
                                        <input class="form-control" type="password" name="" id="passwordField" value="'.$taiKhoan.'" readonly>
                                        <button type="button" class="btn btn-light" onclick="togglePassword(this)"><i class="fas fa-eye-slash"></i></button>
                                    </td>


                                    <td style="text-align:center">
                                        <input class="form-control" type="password" name="" id="passwordField" value="'.$matKhau.'" readonly>
                                        <button type="button" class="btn btn-light" onclick="togglePassword(this)"><i class="fas fa-eye-slash"></i></button>
                                    </td>
                                    <td style="text-align:center">'.$tenLoai.'</td>
                                    <td style="text-align:center">'.$tenNganHang.'</td>
                                    <td style="text-align:center">'.$maPinThe.'</td>
                                    <td style="text-align:center">
                                        <form method="post">
                                            <input type="hidden" name="id_xoa" value="'.$id_taiKhoan.'">
                                            <button class="btn btn-primary btn-sm trash" type="submit" name="nut" value="Xóa" onsubmit="return confirmDelete(event, this);"><i class="fas fa-trash-alt"></i> </button>
                                            <a href="chinhsuathongtin_TaiKhoan.php?id_taiKhoan='.$id_taiKhoan.'"><button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp"><i class="fas fa-edit"></i></button></a> 
                                        </form>
                                    </td>
                                    </tr>';
                }
                echo '
                    </tbody>';
                
            }
            else
            {
                echo '<h3 align="center">Không có dữ liệu</h3>';
            }
            
        }
        public function getDanhMuc($sql)
        {
            $link=$this->connect();
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)>0)
            {
                echo '<table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr >
                    <th style="text-align:center">STT</th>
                    <th style="text-align:center">Tên loại tài khoản</th>
                    <th style="text-align:center">Mô tả</th>
                    <th style="text-align:center">Tính năng</th>
                  </tr>
                </thead>
                <tbody>';
                $count=0;
                while($row=mysqli_fetch_array($result))
                {
                    $id_maTK=htmlspecialchars($row['id_maTK']);
                    $tenLoai=htmlspecialchars($row['tenLoai']);
                    $moTa=htmlspecialchars($row['moTa']);
                    $count++;
                    //mã hóa url id_maTk
                    //$encoded_id = base64_encode($id_maTK);
                    echo '<tr>
                            <td style="text-align:center">'.$count.'</td>
                            <td style="text-align:center">'.$tenLoai.'</td>
                            <td style="text-align:center">'.$moTa.'</td>
                            <td style="text-align:center">
                                <form method="post">
                                    <input type="hidden" name="id_xoa" value="'.$id_maTK.'">
                                    <button class="btn btn-primary btn-sm trash" type="submit" name="nut" value="Xóa"><i class="fas fa-trash-alt"></i> </button>
                                    <a href="chinhsuathongtin_DanhMuc.php?id_maTK='.$id_maTK.'"><button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp"><i class="fas fa-edit"></i></button></a> 
                                </form>
                            </td>
                        </tr>';
                }
                echo '</tr>
                    </tbody>';
                
            }
            else
            {
                echo '<h3 align="center">Không có dữ liệu</h3>';
            }
        }

        public function getTenLoai($sql)
        {
            $link=$this->connect();
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)>0)
            {
                while($row=mysqli_fetch_array($result))
                {
                    $id_maTK=htmlspecialchars($row['id_maTK']);
                    $tenLoai=htmlspecialchars($row['tenLoai']);
                    echo '<option value="'.$id_maTK.'">'.$tenLoai.'</option>';
                    // chống xss
                    //echo '<option value="' . htmlspecialchars($tenLoai) . '">' . htmlspecialchars($tenLoai) . '</option>';
                }
                echo '</select>';
            }
        }

        // xử lý file quanlyDanhMuc.php
        public function checkTenDanhMuc($sql)
        {
            $link=$this->connect();
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)>0)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }

        //xu ly file account.php
        public function getUser($sql)
        {
            $link=$this->connect();
            $result=mysqli_query($link,$sql);
            if(mysqli_num_rows($result)>0)
            {
                echo '<table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr >
                                <th style="text-align:center">STT</th>
                                <th style="text-align:center">Họ</th>
                                <th style="text-align:center">Tên</th>
                                <th style="text-align:center">Số điện thoại</th>
                                <th style="text-align:center">Mật khẩu</th>
                                <th style="text-align:center">Tính năng</th>
                            </tr>
                        </thead>
                        <tbody>';
                $count=0;
                while($row=mysqli_fetch_array($result))
                {
                    $id_user=htmlspecialchars($row['id_user']);
                    $Ho=htmlspecialchars($row['Ho']);
                    $Ten=htmlspecialchars($row['Ten']);
                    $soDienThoai=htmlspecialchars($row['soDienThoai']);
                    $matKhau=htmlspecialchars($row['matKhau']);
                    $count++;
                    echo '<tr>
                            <td style="text-align:center">'.$count.'</td>
                            <td style="text-align:center">'.$Ho.'</td>
                            <td style="text-align:center">'.$Ten.'</td>
                            <td style="text-align:center">'.$soDienThoai.'</td>
                            <td style="text-align:center">'.$matKhau.'</td>
                            <td style="text-align:center">
                                <form method="post">
                                    <input type="hidden" name="id_xoa" value="'.$id_user.'">
                                    <!--<button class="btn btn-primary btn-sm trash" type="submit" name="nut" value="Xóa"><i class="fas fa-trash-alt"></i> </button> -->
                                    
                                    <a href="chinhsua_Account.php"><button class="btn btn-primary btn-sm edit" type="button" title="Sửa" id="show-emp"><i class="fas fa-edit"></i></button></a> 
                                </form>
                            </td>
                        </tr>';
                }
            }
            else
            {
                echo '<h3 align="center">Không có dữ liệu</h3>';
            }
        }
    }
?>
