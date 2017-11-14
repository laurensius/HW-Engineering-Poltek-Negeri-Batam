<?php
	include("sensor.class.php"); 	
?>
<!Doctype HTML>
<html>
	<head>
		<title>Monitoring Suhu dan Kelembaban</title>
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./css/bootstrap.css">
	</head>
	<body>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<center><h3 style="text-align:center;" class="hijau tebel">Monitoring Suhu dan Kelembaban</h3></center>
				<img width=200 height=75 src='logo.png' />
			</div>
			<div class="col-md-2">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<center><h5 style="text-align:center;" class="miring">Pada Clean Room Teaching Factory</h5></center>
				<hr style="margin-top: 0px; margin-bottom:0px">
			</div>
			<div class="col-md-2">
				&nbsp;
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-2 col-md-offset-2">
				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title tengah">Navigasi</h3>
  					</div>
  					<div class="panel-body" style="padding:0px;">
    					<table class="table table-stripped table-hover" >
							<tbody>
								<tr>
									<td><span class="glyphicon glyphicon-home"></span><a href="./index.php" style="text-decoration:none;"> Home</a></td>
								</tr>
								<tr class="info">
									<td><span class="glyphicon glyphicon-th-list" ></span><a href="./tables.php" style="text-decoration:none;"> Tabel</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-stats"></span><a href="./stats.php" style="text-decoration:none;"> Statistik</td>
								</tr>
							</tbody>
						</table>
  					</div>
				</div>	
			</div>
			<div class="col-md-6">
				<p class="tebel">Tabel Data Suhu dan Kelembaban</p>
				Jumlah data : <span id="jumlah_data"></span>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Suhu <sup>o</sup>C</th>
							<th>Kelembaban %</th>
						</tr>
					</thead>
					<tbody id="tabel">

					</tbody>
				</table>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script>
	$(document).ready(function(){
		function load_tabel(){
			var tabel = '';
			$.ajax({
				url : 'loader.php?mode=tabel' ,
				type : 'GET',
				dataType : 'json',
				success : function(response){
					console.log(response);
					if(response.data_hari_ini.length > 0 ){
						var ctr = 1;
						for(var c=0;c<response.data_hari_ini.length;c++){
							tabel += '<tr>';
							tabel += '<td>' + ctr + '</td>';
							tabel += '<td>' + response.data_hari_ini[c].datetime + '</td>';
							tabel += '<td>' + response.data_hari_ini[c].suhu + '</td>';
							tabel += '<td>' + response.data_hari_ini[c].rh + '</td>';
							tabel += '<tr>';
							ctr++;
						}
						$("#tabel").html(tabel);
						$("#jumlah_data").html(response.data_hari_ini.length);
					}
				},
				error : function(response){
					console.log(response);
					
				},
			});
		}
		setInterval(function(){load_tabel();},1000);
	});
	</script>
</html>
