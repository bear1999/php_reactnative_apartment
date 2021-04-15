<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    EditPayInformation::_EditPayInformation();
}

class EditPayInformation
{
    public static function _EditPayInformation()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $queryStr = "UPDATE `information_bank` SET NameBank = '" . $obj['NameBank'] . "', NameAccount = '" . $obj['NameAccount'] . "', 
                    BrandBank = '" . $obj['BrandBank'] . "', NumberAccount = '" . $obj['NumberAccount'] . "', FullNameBank = '" . $obj['FullNameBank'] . "'
                    WHERE idSql = '" . $obj['idSql'] . "'";
        $execQuery = mysqli_query($conn, $queryStr);

        if ($execQuery) $result = 1; //Add thành công
        else  $result = 2; //Add thất bại
        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
