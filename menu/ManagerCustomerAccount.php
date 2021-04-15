<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    ManagerCustomerAccount::LoadDSAccount();
}

class ManagerCustomerAccount
{
    public static function LoadDSAccount()
    {
        $obj = file_get_contents('php://input');
        $obj = json_decode($obj, true);

        $Item_In_Page = 6;
        $Trang = $obj['Page'];
        $From = $Trang * $Item_In_Page;

        $conn = OpenCon(); //Kết nối tới database
        //Load nếu có tìm và có vị trí
        if (isset($obj['TimKiem'])) {
            //Load với chức vụ theo chọn
            $stmt = $conn->prepare("SELECT *
                        FROM account a
                        JOIN `login` c ON a.idUser = c.idUser
                        JOIN position b ON a.idPosition = b.idPosition
                        WHERE (c.idUser LIKE '%" . $obj['TimKiem'] . "%'
                        OR a.Username LIKE '%" . $obj['TimKiem'] . "%'
                        OR c.PhoneNumber LIKE '%" . $obj['TimKiem'] . "%'
                        OR c.Email LIKE '%" . $obj['TimKiem'] . "%')
                        AND a.idPosition = '1'
                        ORDER BY c.idUser DESC LIMIT $From, $Item_In_Page");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($outp);

        CloseCon($conn); //Close database
        die();
    }
}
