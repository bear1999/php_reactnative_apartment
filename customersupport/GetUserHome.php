<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

GetUserHome::_GetUserHome();

class GetUserHome
{
    public static function _GetUserHome()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $stmt = $conn->prepare("SELECT a.idMain, a.name_apartment
                                FROM apartment a
                                JOIN owner_home b ON a.idMain = b.idHome
                                WHERE b.idUser = '" . $obj['idUser'] . "'");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
