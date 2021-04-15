<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    confirmPayRentHouse::_confirmPayRentHouse();
}

class confirmPayRentHouse
{
    public static function _confirmPayRentHouse()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            $conn = OpenCon(); //Kết nối tới database

            $checkValue = "SELECT dateRent, dateExp FROM `rent_house`
                            WHERE idMain = '" . $obj['idMain'] . "';";
            $checkValue = mysqli_query($conn, $checkValue);
            $row = mysqli_fetch_array($checkValue, MYSQLI_ASSOC);

            $dateReg = new DateTime($row["dateRent"]);
            $dateExp = new DateTime($row["dateExp"]);
            $interval = new DateInterval('P30D'); //Add 30 ngày

            $dateReg1 = $dateReg->add($interval);
            $dateReg1 = $dateReg1->format('Y-m-d H:i:s');
            $dateExp1 = $dateExp->add($interval);
            $dateExp1 = $dateExp1->format('Y-m-d H:i:s');
            //=============INSERT HISTORY===================
            $queryStr = "UPDATE `rent_house` SET `dateRent` = '" . $dateReg1 . "', dateExp = '" . $dateExp1 . "' WHERE idMain = '" . $obj['idMain'] . "'";
            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) $result = 1; // thành công
            else $result = 2; // thất bại
            CloseCon($conn); //Close database
            die(json_encode($result));
        }
    }
}
