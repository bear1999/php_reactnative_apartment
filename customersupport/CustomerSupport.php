<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    CustomerSupport::_CustomerSupport();
}

class CustomerSupport
{
    public static function _CustomerSupport()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $Item_In_Page = 6;
        $Trang = $obj['Page'];
        $From = $Trang * $Item_In_Page;

        $conn = OpenCon(); //Kết nối tới database

        $string1 = null;
        $string2 = null;
        if (!isset($obj['TimKiem']))
            $obj['TimKiem'] = null;
        if ($obj['Status'] != 0)
            $string1 = " AND a.ticket_idStatus = '" . $obj['Status'] . "'";
        if ($obj['Position'] != 0)
            $string2 = " AND a.ticket_idPosition = '" . $obj['Position'] . "'";

        $stmt = $conn->prepare("SELECT *
                      FROM ticket a 
                      JOIN account b ON a.idUser_lastpost = b.idUser
                      JOIN position c ON a.ticket_idPosition = c.idPosition
                      JOIN status_general d ON a.ticket_idStatus = d.idStatus
                      JOIN apartment e ON e.idMain = a.idHome
                      WHERE a.idTicket LIKE '%" . $obj['TimKiem'] . "%' {$string1} {$string2}
                      ORDER BY a.dateCreate DESC LIMIT $From, $Item_In_Page");

        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($outp);
        CloseCon($conn); //Close database
        die();
    }
}
