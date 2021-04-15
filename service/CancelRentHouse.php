<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    CancelRentHouse::_CancelRentHouse();
}

class CancelRentHouse
{
    public static function _CancelRentHouse()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database
            //Xóa Apartment
            $queryStr = "DELETE FROM `rent_house` WHERE idMain = '" . $obj["idMain"] . "';";
            $queryStr .= "DELETE FROM `history_service_home` WHERE idHome = '" . $obj["idMain"] . "';";
            $queryStr .= "DELETE FROM `service` WHERE idHome = '" . $obj["idMain"] . "';";
            $queryStr .= "DELETE FROM `owner_home` WHERE idHome = '" . $obj["idMain"] . "';";
            $queryStr .= "UPDATE `apartment` SET idStatus = '2' WHERE idMain = '" . $obj["idMain"] . "';";

            $execQuery = $conn->multi_query($queryStr);
            if ($execQuery) {
                $result = 1; //Xóa thành công
            } else {
                $result = 2; //Xóa thất bại
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
