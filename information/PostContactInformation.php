<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    PostContactInformation::_PostContactInformation();
}

class PostContactInformation
{
    public static function _PostContactInformation()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $queryStr = "INSERT INTO `information_contact` VALUES('', '" . $obj['NameContact'] . "', '" . $obj['AddressContact'] . "', '" . $obj['TelContact'] . "')";
        $execQuery = mysqli_query($conn, $queryStr);

        if ($execQuery) $result = 1; //Add thành công
        else  $result = 2; //Add thất bại
        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
