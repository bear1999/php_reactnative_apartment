<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    DisableAccount::_DisableAccount();
}

class DisableAccount
{
    public static function _DisableAccount()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        //Upload profile
        $conn = OpenCon(); //Kết nối tới database
        //Check trùng Email vs SĐT
        // $checkUNIEQUE = "SELECT Email, PhoneNumber FROM `login` WHERE idUser != '" . $obj["idUser"] . "'";
        // $checkUNIEQUE = mysqli_query($conn, $checkUNIEQUE);
        // $row = mysqli_fetch_array($checkUNIEQUE, MYSQLI_ASSOC);
        if (isset($obj['idUser'])) {
            $queryStr = "UPDATE `login` SET `Disable` = '" . $obj['Disable'] . "' WHERE idUser = '" . $obj['idUser'] . "'";
            $execQuery = mysqli_query($conn, $queryStr);
            if ($execQuery) {
                $result = 1; //UPDATE thành công
            } else {
                $result = 2; //UPDATE thất bại
            }
        }
        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
