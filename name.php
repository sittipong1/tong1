<?php

$input = json_decode($_POST["query"], true);
$query = $input["query"];
$page = $input["page"];

$res = [];
//แปลงข้อความเป็น array
$q = explode( " ", $query);

include('conn.php'); 
$mydb = new db(); // สร้าง object ใหม่ , class db()

$conn = $mydb->connect();

// จัดการลูป

$dText = "";
foreach($q as $key => $value)
{
    if( $key == 0 )
        $dText .= "WHERE";
    if($key > 0 )
        $dText .= " AND ";
//concat เอาคอลัมมาต่อกัน เพื่อค้นหา
        $dText .= 
        "
        
            CONCAT(name, ' ', organization, ' ', title, ' ') LIKE '%". $value ."%'
        ";
}

//ค้นหา count ของข้อมูล
$COUNT= $conn->prepare("

SELECT COUNT(*)as ttt FROM invoice {$dText} 

");

$COUNT->execute();
$rec = $COUNT->fetch(PDO::FETCH_ASSOC);
$ttt = $rec['ttt'];//จำนวนแถวข้อมูล
$rpp = 10; // limit
$startPage = ( $page - 1 ) * $rpp; //หาค่า limit เริ่มต้น
$ttp = ceil($ttt/$rpp);//หาจำนวนหน้า page

//รับค่า Query จากหน้า index.php 
if(!empty($query))
{
// ค้นหาข้อมูลใน database ที่ตรงกับ input 
	
$results = $conn->prepare("SELECT * FROM invoice {$dText}

LIMIT {$startPage},{$rpp};
");
}
else
{
 //ถ้าไม่ได้ input  จะแสดงข้อมูล ใน datadase
 $results = $conn->prepare("SELECT * FROM invoice  LIMIT {$startPage},{$rpp}");

}
//แสดงข้อมูล column database
$results->execute();

$res["result"] = $results->fetchAll(PDO::FETCH_ASSOC);
$res["page"] = $ttp;
$res["currentPage"] = $page;

exit( json_encode( $res ) );


?>