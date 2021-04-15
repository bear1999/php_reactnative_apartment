<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    PostContentSupport::_PostContentSupport();
}

class PostContentSupport
{
    public static function _PostContentSupport()
    {
        //Nếu không up image thì xài cái này
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database
        //Add Apartment
        $queryStr = "INSERT INTO ticket_text VALUES('', '" . $obj['idTicket'] . "', '" . $obj['idUser'] . "', NOW(), '" . $obj['content'] . "')";
        $update = "UPDATE ticket SET ticket_idStatus = '5', idUser_lastpost = '" . $obj['idUser'] . "' WHERE idTicket = '" . $obj['idTicket'] . "'"; // 5 đã trả lời
        mysqli_query($conn, $update);

        $execQuery = mysqli_query($conn, $queryStr);
        if ($execQuery) $result = 1; //Add thành công
        else $result = 2; //Add thất bại

        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
