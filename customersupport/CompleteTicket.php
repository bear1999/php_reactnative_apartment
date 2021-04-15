<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    CompleteTicket::_CompleteTicket();
}

class CompleteTicket
{
    public static function _CompleteTicket()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        //Add Apartment
        $queryStr = "UPDATE ticket SET ticket_idStatus = '7', closed = '1' WHERE idTicket = '" . $obj['idTicket'] . "'"; // 7 Hoàn thành

        $execQuery = mysqli_query($conn, $queryStr);
        if ($execQuery) $result = 1; //Add thành công
        else $result = 2; //Add thất bại

        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
