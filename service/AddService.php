<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	AddService::_AddService();
}

class AddService
{
	public static function _AddService()
	{
		//Nếu không up image thì xài cái này
		$obj = $_POST;
		$files = $_FILES;

		if (isset($obj) && isset($files['photo']['tmp_name'])) { //Kiểm tra xem có dữ liệu 
			//Upload Avatar
			$folderUpload = "../assets/logoService";
			$pathAvatar = rand() . "-" . time() . ".jpg";
			if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
				die(json_encode('Upload ảnh đại diện thất bại!'));
			}

			$conn = OpenCon(); //Kết nối tới database
			//Add Apartment
			$string = "'', '" . $obj['name_service'] . "', '" . $obj['description_service'] . "', '" . $obj['price_service'] . "', '" . $obj['unit'] . "',
							  '" . $obj['type'] . "', '" . $pathAvatar . "'";

			$queryStr = "INSERT INTO type_service VALUES(" . $string . ")";

			$execQuery = mysqli_query($conn, $queryStr);
			if ($execQuery) {
				$result = 1; //Add thành công
			} else {
				$result = 2; //Add thất bại
			}
			CloseCon($conn); //Close database
			die(json_encode($result));
		}
	}
}
