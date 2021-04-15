<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ContentSupport::_ContentSupport();
}

class ContentSupport
{
    public static function _ContentSupport()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        $stmt = $conn->prepare("SELECT a.*, b.Username, c.namePosition
                      FROM ticket_text a
                      JOIN account b ON a.idUser_post = b.idUser
                      JOIN position c ON b.idPosition = c.idPosition
                      WHERE a.idTicket = '" . $obj['idTicket'] . "'
                      ORDER BY a.dateSend DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);
        CloseCon($conn); //Close database
        die();
    }
}
