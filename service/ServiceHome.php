<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ServiceHome::_ServiceHome();
}

class ServiceHome
{
    public static function _ServiceHome()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $Item_In_Page = 6;
        $Trang = $obj['Page'];
        $From = $Trang * $Item_In_Page;

        $conn = OpenCon(); //Kết nối tới database
        //Load nếu có tìm và có vị trí

        //typeTime 0: tất cả, 1: gần tới 3 ngày, 2: quá hạn
        if ($obj['typeTime'] == 2)
            $str1 = "a.expDate < NOW() AND ";
        else if ($obj['typeTime'] == 1)
            $str1 = "DATEDIFF(NOW(), a.expDate) <= 0 AND DATEDIFF(NOW(), a.expDate) >= -3 AND ";
        else $str1 = null;
        //filter theo loại dịch vụ
        if ($obj['typeService'] != 0)
            $str = "a.type_service = '" . $obj['typeService'] . "' AND ";
        else $str = null;

        $stmt = $conn->prepare("SELECT *
                        FROM `service`a 
                        JOIN `type_service` b ON a.type_service = b.idType_service
                        WHERE {$str} {$str1}
                        (a.idService LIKE '%" . $obj['TimKiem'] . "%'
                        OR a.idHome LIKE '%" . $obj['TimKiem'] . "%'
                        OR b.name_service LIKE '%" . $obj['TimKiem'] . "%')
                        ORDER BY a.idService DESC LIMIT $From, $Item_In_Page");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
