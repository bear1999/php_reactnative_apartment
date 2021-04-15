<?php
include '../../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    InfoService::_InfoService();
}

class InfoService
{
    public static function _InfoService()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        //Load nếu có tìm và có vị trí
        $stmt = $conn->prepare("SELECT *
                        FROM `service`a 
                        JOIN `type_service` b ON a.type_service = b.idType_service
                        WHERE idHome = " . $obj['idMain'] . "");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
