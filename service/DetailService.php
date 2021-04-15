<?php
require('../db_connection.php');
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    DetailService::_DetailService();
}

class DetailService
{
    public static function _DetailService()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database

        if (isset($obj)) {
            $stmt = $conn->prepare("SELECT *
									FROM `type_service`
									WHERE idType_service = {$obj["idType_service"]}");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
