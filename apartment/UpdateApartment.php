<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
	UpdateApartment::CapNhatCanHo();
}

class UpdateApartment
{
	public static function CapNhatCanHo()
	{
		//Nếu không up image thì xài cái này
		$obj = file_get_contents('php://input');
		$obj = json_decode($obj, true);

		if (isset($obj)) { //Kiểm tra xem có dữ liệu 
			$conn = OpenCon(); //Kết nối tới database

			$queryStr = "UPDATE `apartment` SET name_apartment = '" . $obj['Tittle'] . "', type_apartment = '" . $obj['idType_apartment'] . "',
                    idStatus = '" . $obj['idStatus'] . "' WHERE idMain = '" . $obj['idMain'] . "';";

			if ($obj['idStatus'] == 1) {

				$date = new DateTime();
				$interval = new DateInterval('P30D'); //Add 7 ngày vô datetime lúc đăng nhập
				$datenow = $date->add($interval);
				$datenow = $datenow->format('Y-m-d H:i:s');

				$check = "SELECT * FROM `rent_house` WHERE idMain = '" . $obj['idMain'] . "';";
				$exCheck = mysqli_query($conn, $check);
				if (mysqli_num_rows($exCheck) == 0)
					$queryStr .= "INSERT INTO rent_house VALUES('', '" . $obj['idMain'] . "', '" . $obj['priceRent'] . "', NOW(), '" . $datenow . "');";
				else
					$queryStr .= "UPDATE `rent_house` SET priceRent = '" . $obj['priceRent'] . "', dateRent = NOW(), dateExp = '" . $datenow . "';";
			} 
			else $queryStr .= "DELETE FROM `rent_house` WHERE idMain ='" . $obj['idMain'] . "';";

			$execQuery = $conn->multi_query($queryStr);
			if ($execQuery) {
				$result = 1; // thành công
			} else {
				$result = 2; // thất bại
			}
			CloseCon($conn); //Close database
			die(json_encode($result));
		}
	}
}
