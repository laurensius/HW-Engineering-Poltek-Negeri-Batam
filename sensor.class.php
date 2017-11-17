<?php
class Sensor{
	
	function __construct(){
		date_default_timezone_set("Asia/Jakarta");
		$this->connection = mysqli_connect("localhost","root","laurens23");
		mysqli_select_db($this->connection,"db_sensor");
	}
	
	function simpan_data(){
		$query = "insert into t_suhu values('','".$_GET["suhu"]."','".$_GET["rh"]."','".date("Y-m-d H:i:s")."')";
		$exec = mysqli_query($this->connection,$query);
		if($exec){
			echo "#Success^";
		}else{
			echo "#Error^";
		}	
	}
	
	function ambil_data_terakhir(){
		$query = "select * from t_suhu order by id desc limit 1";
		$hasil = mysqli_query($this->connection,$query) or die(mysqli_error());
		return mysqli_fetch_object($hasil);
	}

	function jumlah_data(){
		$query = "select count(*) as jumlah from t_suhu";
		$hasil = mysqli_query($this->connection,$query) or die(mysqli_error());
		return mysqli_fetch_object($hasil);
	}

	function data_hari_ini(){
		$query = "select * from t_suhu where datetime like '".date("Y-m-d")."%' order by id desc";
		$hasil = mysqli_query($this->connection,$query) or die(mysqli_error());
		$x = 0;
		$object = null;
		while ($data = mysqli_fetch_object($hasil)){
			$object[$x]["id"] = $data->id;
			$object[$x]["suhu"] = $data->suhu;
			$object[$x]["rh"] = $data->rh;
			$object[$x]["datetime"] = $data->datetime;
			$x++;
		}
		return $object;
	}
}

?>