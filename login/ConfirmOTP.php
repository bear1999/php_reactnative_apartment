<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ConfirmOTP::_ConfirmOTP();
}

class ConfirmOTP
{
    public static function _ConfirmOTP()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $obj['MatKhau'] = md5($obj['MatKhau']); //Mã hóa password
            //Upload profile
            $conn = OpenCon(); //Kết nối tới database

            //UPDATE password
            $queryStr = "UPDATE `login` SET `Password` = '" . $obj['MatKhau'] . "' WHERE Email = " . $obj['Email'] . "";

            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) {
                $result = 1; //UPDATE thành công
            } else {
                $result = 2; //UPDATE thất bại
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
