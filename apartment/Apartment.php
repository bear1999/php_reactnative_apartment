<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	ListApartment::_ListApartment();
}

class ListApartment
{
	public static function _ListApartment()
	{
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		$conn = OpenCon(); //Kết nối tới database

		if (isset($obj)) {
			$stmt = $conn->prepare("SELECT a.idMain, a.name_apartment, b.name_type_apartment, c.name_status, a.idStatus, a.type_apartment, d.priceRent
											FROM `apartment` a
											JOIN type_apartment b ON a.type_apartment = b.idType_apartment
											JOIN status_general c ON a.idStatus = c.idStatus
											LEFT JOIN rent_house d ON a.idMain = d.idMain
											WHERE a.idSub = '" . $obj['idMain'] . "'
											ORDER BY a.name_apartment ASC");
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		echo json_encode($outp);
		CloseCon($conn); //Close database
		die();
	}
}
