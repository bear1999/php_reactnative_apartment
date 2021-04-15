<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	ThemCanHo::_ThemCanHo();
}

class ThemCanHo
{
	public static function _ThemCanHo()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database
			//Add Apartment
			if (isset($obj['idSub']))
				$string = "'', '" . $obj['idSub'] . "', '" . $obj['Tittle'] . "', '" . $obj['idType_apartment'] . "', '" . $obj['idStatus'] . "'";
			else
				$string = "'', 0, '" . $obj['Tittle'] . "', '" . $obj['idType_apartment'] . "', '" . $obj['idStatus'] . "'";

			$queryStr = "INSERT INTO apartment (idMain, idSub, name_apartment, type_apartment, idStatus)
									 VALUES(" . $string . ");";
			if ($obj['idType_apartment'] == 4 && $obj['idStatus'] == 1) {
				$date = new DateTime();
				$interval = new DateInterval('P30D'); //Add 7 ngày vô datetime lúc đăng nhập
				$datenow = $date->add($interval);
				$datenow = $datenow->format('Y-m-d H:i:s');

				$queryStr .= "SET @idNe = LAST_INSERT_ID();";
				$queryStr .= "INSERT INTO rent_house VALUES('', @idNe, '" . $obj['priceRent'] . "', NOW(), '" . $datenow . "');";
			}

			$execQuery = $conn->multi_query($queryStr);
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
