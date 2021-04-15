<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

include '../../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    regServiceApartment::_regServiceApartment();
}

class regServiceApartment
{
    public static function _regServiceApartment()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 

            $conn = OpenCon(); //Kết nối tới database
            //Add Apartment
            $date = new DateTime();
            $interval = new DateInterval('P30D'); //Add 30 ngày
            $datenow = $date->add($interval);
            $datenow = $datenow->format('Y-m-d H:i:s');

            $queryStr = "INSERT INTO `service` 
                        VALUES('' , NOW(), '" . $datenow . "', '" . $obj["idType_service"] . "', " . $obj["idMain"] . ", null)";

            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) {
                $result = 1; //Add thành công
            } else {
                $result = 2; //Add thất bại
            }
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
