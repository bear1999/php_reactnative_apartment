<?php
include '../../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	UserInHome::_UserInHome();
}

class UserInHome
{
	public static function _UserInHome()
	{
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		$conn = OpenCon(); //Kết nối tới database
		//Load nếu có tìm và có vị trí
		$stmt = $conn->prepare("SELECT *
                        FROM `login` a 
                        JOIN account c ON c.idUser = a.idUser
                        JOIN position b ON c.idPosition = b.idPosition
						JOIN owner_home d ON d.idUser = a.idUser
						WHERE d.idHome = " . $obj['idMain'] . "");
		$stmt->execute();
		$result = $stmt->get_result();
		$outp = $result->fetch_all(MYSQLI_ASSOC);

		echo json_encode($outp);

		CloseCon($conn); //Close database
		die();
	}
}
