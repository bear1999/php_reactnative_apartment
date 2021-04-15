<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    ContactInformation::_ContactInformation();
}

class ContactInformation
{
    public static function _ContactInformation()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        //Load nếu có tìm và có vị trí
        $stmt = $conn->prepare("SELECT * FROM `information_contact` ORDER BY idSql DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
