<?php

include('conn.php');
$mydb = new db(); // สร้าง object ใหม่ , class db()


$conn = $mydb->connect();
//รับค่า id จากหน้า name.php 
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $resu = $conn->prepare("SELECT * FROM invoice_item   WHERE  invoice_id = $id ");
}

$resu->execute();
$row = $resu->fetch(PDO::FETCH_ASSOC);
$invoice_id = $row['invoice_id'] ?? ""; //กำหนดค่า invoice_id ถ้าไม่มีให้เป็นค่าว่าง

//มีข้อมูลใน invoice_item จะแสดงข้อมูล 
if ($id == $invoice_id) {
    $res = $conn->prepare("SELECT * FROM invoice_item   WHERE  invoice_id = $id  ");
    $res->execute();
    //แสดงข้อมูลจนกว่าข้อมูลจะหมด
    while($row1 = $res->fetch(PDO::FETCH_ASSOC)){

    echo
    "<br> invoice_id: " . $row1['invoice_id'] . " <br>" .
    "description: " . $row1['description'] . " <br>" .
        "price: " . $row1['price'] . "<br>" .
        "vat: " . $row1['vat'] . "<br>" .
        "before_vat: " . $row['before_vat'] . "<br>" .
        "total: " . $row1['total'] . "<br>
        --------------------------------------------------<br>";
    }
} else {
    //ถ้าไม่มีข้อมูล
    echo "ไม่มีข้อมูล"; //ไม่มีข้อมูลใน  invoice_item
}
