<?php
include '../db_connection.php';
include '../SendMail.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ForgotPassword::_ForgotPassword();
}

class ForgotPassword
{
    public static function _ForgotPassword()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database
            //Check password
            $checkUNIQUE = "SELECT `Email` FROM `login` WHERE `Email` = '" . $obj['Email'] . "'";
            $execUNIQUE = mysqli_query($conn, $checkUNIQUE);
            $row = mysqli_fetch_array($execUNIQUE, MYSQLI_ASSOC);
            $result = 1; //Email không tồn tại
            if (isset($row["Email"])) {
                $otp = rand(100000, 999999);
                $body = '<div><span style="font-size: 16px;">Mã OTP: ' . $otp . '</span><br>
                            <span style="color: red; font-weight: bold; font-size: 16px;"><i>Lưu ý: Mã OTP của bạn chỉ có thời hạn trong vòng 120 giây</i></span>
                        </div>';
                $result = $otp; //Mã OTP đã đc gửi tới Email
                SendMail::_SendMail($obj['Email'], "[No Reply] Quên mật khẩu", $body);
                die(json_encode($result));
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
