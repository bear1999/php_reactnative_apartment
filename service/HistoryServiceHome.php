<?php
require('../db_connection.php');
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    HistoryServiceHome::_HistoryServiceHome();
}

class HistoryServiceHome
{
    public static function _HistoryServiceHome()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $conn = OpenCon(); //Kết nối tới database

        if (isset($obj)) {
            $stmt = $conn->prepare("SELECT *
									FROM `history_service_home`
                                    where idHome = '" . $obj['idHome'] . "'
									ORDER BY idHistory DESC");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        CloseCon($conn); //Close database
        die(json_encode($outp));
    }
}
