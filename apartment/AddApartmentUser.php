<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	AddApartmentUser::ThemCanHoNguoiDung();
}

class AddApartmentUser
{
	public static function ThemCanHoNguoiDung()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database
			//Add Apartment
			$queryStr = "INSERT INTO owner_home (idUser, idHome) VALUES('" . $obj['idUser'] . "', '" . $obj['idHome'] . "')";

			$execQuery = mysqli_query($conn, $queryStr);
			if ($execQuery) {
				$result = 2; //Add thành công
			} else {
				$result = 3; //Add thất bại, tồn tài căn hộ/ ko tồn tại
			}
			CloseCon($conn); //Close database
			die(json_encode($result));
		}
	}
}
