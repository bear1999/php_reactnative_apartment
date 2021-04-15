<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	UpdateApartmentUser::loadApartmentUser();
}

class UpdateApartmentUser
{
	public static function loadApartmentUser()
	{
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		$idUser = $obj['idUser'];

		$conn = OpenCon(); //Kết nối tới database
		$stmt = $conn->prepare("SELECT b.idMain, b.name_apartment
													FROM owner_home a
													INNER JOIN apartment b ON a.idHome = b.idMain
													WHERE a.idUser = '$idUser'");

		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);

		echo json_encode($outp);
		CloseCon($conn); //Close database
		die();
	}
}
