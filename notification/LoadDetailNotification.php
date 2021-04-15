<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    LoadDetailNotification::_LoadDetailNotification();
}

class LoadDetailNotification
{
    public static function _LoadDetailNotification()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $stmt = $conn->prepare("SELECT a.*, b.Username
                                FROM `notification` a
                                JOIN `account` b ON b.idUser = a.notify_idUserPost
                                WHERE a.idNotify = '" . $obj['idNotify'] . "'");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
