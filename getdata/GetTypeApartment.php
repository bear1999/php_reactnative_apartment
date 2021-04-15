<?php
include '../db_connection.php';
header("Content-Type: application/json; charset=UTF-8");

getTypeApartment::_getTypeApartment();

class getTypeApartment
{
  public static function _getTypeApartment()
  {
    $conn = OpenCon(); //Kết nối tới database

    $stmt = $conn->prepare("SELECT idType_apartment, name_type_apartment FROM type_apartment");
    $stmt->execute();
    $result = $stmt->get_result();
    $outp = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($outp);

    CloseCon($conn); //Close database
    die();
  }
}
