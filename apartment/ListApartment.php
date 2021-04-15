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

		$Item_In_Page = 6;
		$Trang = $obj['Page'];
		$From = $Trang * $Item_In_Page;

		$conn = OpenCon(); //Kết nối tới database
		//Check chức vụ
		if ($obj['idStatus'] != 0) {
			$query = "AND a.idStatus = '" . $obj['idStatus'] . "'";
		} else {
			$query = "";
		}

		if (isset($obj)) {
			$stmt = $conn->prepare("SELECT a.idMain, a.idSub, a.name_apartment, c.name_status, b.name_type_apartment, a.idStatus, a.type_apartment
											FROM `apartment` a 
											JOIN type_apartment b ON a.type_apartment = b.idType_apartment
											JOIN status_general c ON a.idStatus = c.idStatus
											WHERE a.type_apartment = '" . $obj['idType_apartment'] . "' " . $query . " 
											AND (a.idMain LIKE '%" . $obj['TimKiem'] . "%'
											OR a.name_apartment LIKE '%" . $obj['TimKiem'] . "%')
											ORDER BY a.idMain DESC LIMIT $From, $Item_In_Page");
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);

		echo json_encode($outp);

		CloseCon($conn); //Close database
		die();
	}
}
