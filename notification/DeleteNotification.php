<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	DeleteNotification::_DeleteNotification();
}

class DeleteNotification
{
	public static function _DeleteNotification()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database			
			
			$queryStr1 = "SELECT pathImage FROM `notification` WHERE idNotify = '" . $obj["idNotify"] . "'";
			$execLogin = mysqli_query($conn, $queryStr1);
			$row = mysqli_fetch_array($execLogin, MYSQLI_ASSOC);
			$folderUpload = "../assets/imageNotification";
			unlink($folderUpload . "/" . $row['pathImage']);

			$queryStr = "DELETE FROM `notification` WHERE idNotify = '" . $obj["idNotify"] . "'";

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
