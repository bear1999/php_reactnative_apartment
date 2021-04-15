<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    EditTypeService::_EditTypeService();
}

class EditTypeService
{
    public static function _EditTypeService()
    {
        //Nếu không up image thì xài cái này
        $obj = $_POST;
        $files = $_FILES;

        $string = ", imageTypeService = '" . $obj['imageTypeService'] . "'";
        if (isset($obj)) { //Kiểm tra xem có dữ liệu 
            if (isset($files['photo']['tmp_name'])) {
                $folderUpload = "../assets/logoService";
                $pathAvatar = rand() . "-" . time() . ".jpg";
                unlink($folderUpload . "/" . $obj['imageTypeService']);
                $string = ", imageTypeService = '" . $pathAvatar . "'";
                if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
                    die(json_encode('Upload ảnh đại diện thất bại!'));
                }
            }

            $conn = OpenCon(); //Kết nối tới database

            $queryStr = "UPDATE `type_service` SET name_service = '" . $obj['name_service'] . "', description_service = '" . $obj['description_service'] . "',
                    price_service = '" . $obj['price_service'] . "', unit = '" . $obj['unit'] . "', type = '" . $obj['type'] . "' $string
                    WHERE idType_service = '" . $obj['idType_service'] . "'";

            $execQuery = mysqli_query($conn, $queryStr);
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
