<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    UpdateServiceHome::_UpdateServiceHome();
}

class UpdateServiceHome
{
    public static function _UpdateServiceHome()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database
            $queryStr = "UPDATE `service` SET `value` = '" . $obj['value'] . "' WHERE idService = '" . $obj['idService'] . "'";
            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) {
                $result = 1; // thành công
            } else {
                $result = 2; // thất bại
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
