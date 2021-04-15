<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

require('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    PostNotification::_PostNotification();
}

class PostNotification
{
    public static function _PostNotification()
    {
        //Nếu không up image thì xài cái này
        $obj = $_POST;
        $files = $_FILES;

        //Upload Avatar
        $folderUpload = "../assets/imageNotification";
        $pathAvatar = rand() . "-" . time() . ".jpg";
        if (!move_uploaded_file($files['photo']['tmp_name'], $folderUpload . "/" . $pathAvatar)) {
            die(json_encode('Upload ảnh đại diện thất bại!'));
        }
        $conn = OpenCon(); //Kết nối tới database
        $queryStr = "INSERT INTO `notification` VALUES('', '" . $obj['Title'] . "', '" . $obj['Content'] . "', NOW(), '" . $obj['idPost'] . "', '" . $obj['typePost'] . "', '" . $pathAvatar . "')";
        $execQuery = mysqli_query($conn, $queryStr);

        if ($execQuery) $result = 1; //Add thành công
        else  $result = 2; //Add thất bại
        CloseCon($conn); //Close database
        die(json_encode($result));
    }
}
