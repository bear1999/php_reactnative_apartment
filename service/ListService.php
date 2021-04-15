<?php
require('../db_connection.php');
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	ListService::_ListService();
}

class ListService
{
	public static function _ListService()
	{
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		$Item_In_Page = 6;
		$Trang = $obj['Page'];
		$From = $Trang * $Item_In_Page;

		$conn = OpenCon(); //Kết nối tới database

		if (isset($obj)) {
			$string = null;
			if ($obj['HeSo'] != -1)
				$string = "AND type = '" . $obj['HeSo'] . "'";

			$stmt = $conn->prepare("SELECT *
									FROM `type_service`
									WHERE (name_service LIKE '%" . $obj['TimKiem'] . "%'
									OR description_service LIKE '%" . $obj['TimKiem'] . "%'
									OR unit LIKE '%" . $obj['TimKiem'] . "%') {$string}
									ORDER BY idType_service DESC LIMIT $From, $Item_In_Page");
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);

		echo json_encode($outp);

		CloseCon($conn); //Close database
		die();
	}
}
