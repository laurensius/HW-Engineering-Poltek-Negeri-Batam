<?php
include "sensor.class.php";
$sensor = new Sensor();
header('Content-Type:JSON');
if($_GET["mode"]=="recent"){
	$data = array(
		"data_terakhir" => $sensor->ambil_data_terakhir(),
		"jumlah_data" => $sensor->jumlah_data()
	);
	echo json_encode($data,JSON_PRETTY_PRINT);
}else
if($_GET["mode"]=="tabel" || $_GET["mode"]=="grafik"){
	$data = array(
		"data_hari_ini" => $sensor->data_hari_ini()
	);
	echo json_encode($data,JSON_PRETTY_PRINT);
}

?>