<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    EditNotification::_EditNotification();
}

class EditNotification
{
    public static function _EditNotification()
    {
        //Nếu không up image thì xài cái này
        $obj = $_POST;
        $files = $_FILES;

        $string = null;
        if (isset($files['photo']['tmp_name'])) {
            $folderUpload = "../assets/imageNotification";
            $pathAvatar = rand() . "-" . time() . ".jpg";
            unlink($folderUpload . "/" . $obj['pathImage']);
            $string = ", pathImage = '" . $pathAvatar . "'";
            if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
                die(json_encode('Upload ảnh đại diện thất bại!'));
            }
        }
        $conn = OpenCon(); //Kết nối tới database
        $queryStr = "UPDATE `notification` SET notify_title = '" . $obj['title'] . "', notify_text = '" . $obj['content'] . "',
                    notify_idUserPost = '" . $obj['idPost'] . "', notify_datePost = NOW() {$string}
                    WHERE idNotify = '" . $obj['idNotify'] . "'";

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
