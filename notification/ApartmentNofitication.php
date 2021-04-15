<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ApartmentNotification::_ApartmentNotification();
}

class ApartmentNotification
{
    public static function _ApartmentNotification()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $Item_In_Page = 12;
        $Trang = $obj['Page'];
        $From = $Trang * $Item_In_Page;

        $conn = OpenCon(); //Kết nối tới database
        $stmt = $conn->prepare("SELECT a.* , b.Username
                        FROM `notification` a 
                        JOIN account b ON b.idUser = a.notify_idUserPost
                        WHERE a.notify_typeUser = '" . $obj['type'] . "'
                        ORDER BY a.notify_datePost DESC LIMIT $From, $Item_In_Page");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
