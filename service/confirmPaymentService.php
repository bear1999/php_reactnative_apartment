<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    confirmPaymentService::_confirmPaymentService();
}

class confirmPaymentService
{
    public static function _confirmPaymentService()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database

            $checkValue = "SELECT * FROM `service` a
                            JOIN `type_service` b ON a.type_service = b.idType_service
                            WHERE a.idService = '" . $obj['idService'] . "'";
            $checkValue = mysqli_query($conn, $checkValue);
            $row = mysqli_fetch_array($checkValue, MYSQLI_ASSOC);
            if (($row['value'] == 0 || !isset($row['value'])) && $row['type'] == 1) die(json_encode(3)); //Chưa cập nhật hệ số
            //$expDate = new DateTime($row['expDate']);
            //die(json_encode($date));
            //if($expDate < $date) die(json_encode(4)); //Chưa tới ngày thanh toán
            $dateReg = new DateTime($row["regDate"]);
            $dateExp = new DateTime($row["expDate"]);
            $interval = new DateInterval('P30D'); //Add 30 ngày

            $dateReg1 = $dateReg->add($interval);
            $dateReg1 = $dateReg1->format('Y-m-d H:i:s');
            $dateExp1 = $dateExp->add($interval);
            $dateExp1 = $dateExp1->format('Y-m-d H:i:s');
            //=============INSERT HISTORY===================
            $queryStr = "UPDATE `service` SET `value` = null, regDate = '" . $dateReg1 . "', expDate = '" . $dateExp1 . "' WHERE idService = '" . $obj['idService'] . "'";
            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) {
                $result = 1; // thành công
                //=============INSERT HISTORY===================
                $insertHistory = "INSERT INTO history_service_home VALUES(null, '" . $row['regDate'] . "', '" . $row['expDate'] . "', '" . $row['type_service'] . "', '" . $row['idHome'] . "',
                                    '" . $row['value'] . "', '" . $row['name_service'] . "', '" . $obj['TongTien'] . "', 1)"; //1 là đã thanh toán, 0 là hủy dịch vụ
                mysqli_query($conn, $insertHistory);
                //=================================
            } else {
                $result = 2; // thất bại
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
