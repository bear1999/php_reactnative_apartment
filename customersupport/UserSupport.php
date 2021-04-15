<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    UserSupport::_UserSupport();
}

class UserSupport
{
    public static function _UserSupport()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $Item_In_Page = 6;
        $Trang = $obj['Page'];
        $From = $Trang * $Item_In_Page;

        $conn = OpenCon(); //Kết nối tới database
        $stmt = $conn->prepare("SELECT *
                      FROM ticket a 
                      JOIN account b ON a.idUser_lastpost = b.idUser
                      JOIN position c ON a.ticket_idPosition = c.idPosition
                      JOIN status_general d ON a.ticket_idStatus = d.idStatus
                      JOIN apartment e ON a.idHome = e.idMain
                      WHERE a.idUser_create = '" . $obj['idUser'] . "'
                      ORDER BY a.dateCreate DESC LIMIT $From, $Item_In_Page");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);
        CloseCon($conn); //Close database
        die();
    }
}
