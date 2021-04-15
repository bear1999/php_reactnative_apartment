<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    CancelService::_CancelService();
}

class CancelService
{
    public static function _CancelService()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database
            //=============INSERT HISTORY===================
            $checkValue = "SELECT * FROM `service` a 
                                JOIN `type_service` b ON a.type_service = b.idType_service 
                                WHERE idService = '" . $obj['idService'] . "'";
            $checkValue = mysqli_query($conn, $checkValue);
            $row = mysqli_fetch_array($checkValue, MYSQLI_ASSOC);
            $result = 2;
            if (isset($row)) {
                $TongTien = $row['value'] * $row['price_service'];
                $insertHistory = "INSERT INTO history_service_home VALUES(null, '" . $row['regDate'] . "', '" . $row['expDate'] . "', '" . $row['type_service'] . "', '" . $row['idHome'] . "',
                                '" . $row['value'] . "', '" . $row['name_service'] . "', '" . $TongTien . "', 0)"; //1 là đã thanh toán, 0 là hủy dịch vụ
                mysqli_query($conn, $insertHistory);
                //=================================
                $remove = "DELETE FROM `service` WHERE idService = '" . $obj['idService'] . "'";
                $execQuery = mysqli_query($conn, $remove);
                if ($execQuery) $result = 1;
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
