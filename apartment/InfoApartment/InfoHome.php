<?php
include '../../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	InfoHome::_InfoHome();
}

class InfoHome
{
	public static function _InfoHome()
	{
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		$conn = OpenCon(); //Kết nối tới database
		//Load nếu có tìm và có vị trí
		$stmt = $conn->prepare("SELECT a.*, b.*, c.idRent, c.priceRent, c.dateExp, c.dateRent
                        FROM `apartment` a 
                        JOIN status_general b ON b.idStatus = a.idStatus
						LEFT JOIN rent_house c ON a.idMain = c.idMain
                        WHERE a.idMain = '" . $obj['idMain'] . "'");
		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);

		echo json_encode($outp);

		CloseCon($conn); //Close database
		die();
	}
}
