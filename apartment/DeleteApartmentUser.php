<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	DeleteApartmentUser::XoaCanHoNguoiDung();
}

class DeleteApartmentUser
{
	public static function XoaCanHoNguoiDung()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database
			//Xóa Apartment
			$queryStr = "DELETE FROM `owner_home` WHERE idUser = '" . $obj["idUser"] . "' AND idHome = '" . $obj["delHome"] . "'";

			$execQuery = mysqli_query($conn, $queryStr);
			if ($execQuery) {
				$result = 1; //Xóa thành công
			} else {
				$result = 2; //Xóa thất bại
			}
			CloseCon($conn); //Close database
			die(json_encode($result));
		}
	}
}
