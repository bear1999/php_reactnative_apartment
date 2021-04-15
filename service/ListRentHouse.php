<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ListRentHouse::_ListRentHouse();
}

class ListRentHouse
{
    public static function _ListRentHouse()
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
            $str1 = " AND b.dateExp < NOW() ";
        else if ($obj['typeTime'] == 1)
            $str1 = " AND DATEDIFF(NOW(), b.dateExp) <= 0 AND DATEDIFF(NOW(), b.dateExp) >= -3 ";
        else $str1 = null;

        $stmt = $conn->prepare("SELECT *
                        FROM apartment a
                        JOIN rent_house b ON a.idMain = b.idMain 
                        WHERE b.idMain LIKE '%" . $obj['TimKiem'] . "%'" . $str1 . "
                        ORDER BY b.dateExp DESC LIMIT $From, $Item_In_Page");
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
