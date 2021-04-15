<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    EditContactInformation::_EditContactInformation();
}

class EditContactInformation
{
    public static function _EditContactInformation()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $queryStr = "UPDATE `information_contact` SET NameContact = '" . $obj['NameContact'] . "', AddressContact = '" . $obj['AddressContact'] . "', 
                    TelContact = '" . $obj['TelContact'] . "'
                    WHERE idSql = '" . $obj['idSql'] . "'";
        $execQuery = mysqli_query($conn, $queryStr);
        if ($execQuery) $result = 1; //Add thành công
        else  $result = 2; //Add thất bại
        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
