<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    PostSupport::_PostSupport();
}

class PostSupport
{
    public static function _PostSupport()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        //Add Apartment
        $queryStr = "INSERT INTO ticket VALUES('', '" . $obj['position'] . "', 8, NOW(), '" . $obj['title'] . "', 0, '" . $obj['idUser'] . "','" . $obj['idUser'] . "', '" . $obj['idHome'] . "');"; //8 trạng thái mới, 0 trạng thái mở
        $queryStr .= "SET @idNe = LAST_INSERT_ID();";
        $queryStr .= "INSERT INTO ticket_text VALUES('', @idNe, '" . $obj['idUser'] . "', NOW(), '" . $obj['content'] . "');";

        $execQuery = $conn->multi_query($queryStr);
        if ($execQuery) $result = 1; //Add thành công
        else $result = 2; //Add thất bại

        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
