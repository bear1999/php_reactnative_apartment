<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	DeleteTypeService::_DeleteTypeService();
}

class DeleteTypeService
{
	public static function _DeleteTypeService()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database			
			
			$queryStr1 = "SELECT imageTypeService FROM `type_service` WHERE idType_service = '" . $obj["idType_service"] . "'";
			$execLogin = mysqli_query($conn, $queryStr1);
			$row = mysqli_fetch_array($execLogin, MYSQLI_ASSOC);
			$folderUpload = "../assets/logoService";
			unlink($folderUpload . "/" . $row['imageTypeService']);

			$queryStr = "DELETE FROM `type_service` WHERE idType_service = '" . $obj["idType_service"] . "'";

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
