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
								<tr>
									<td><span class="glyphicon glyphicon-th-list" ></span><a href="./tables.php" style="text-decoration:none;"> Tabel</a></td>
								</tr>
								<tr  class="info">
									<td><span class="glyphicon glyphicon-stats"></span><a href="./stats.php" style="text-decoration:none;"> Statistik</td>
								</tr>
							</tbody>
						</table>
  					</div>
				</div>	
			</div>
			<div class="col-md-6">
				<div id="container1">
				</div>
				<br><br><br><br>
				<div id="container2">
				</div>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/modules/data.js"></script>
	<script type="text/javascript" src="./js/modules/exporting.js"></script>
	<script type="text/javascript" src="./js/highcharts.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script>
	$(document).ready(function(){
		function load_data(){
			var tabel = '';
			$.ajax({
				url : 'loader.php?mode=tabel' ,
				type : 'GET',
				dataType : 'json',
				success : function(response){
					// console.log(response);
					if(response.data_hari_ini.length > 0 ){
						var array_suhu = new Array();
						var array_kelembaban = new Array();
						var data_ke = new Array();
						var ctr = 0;
						var urutan_data;
						urutan_data = 1;
						for(var c=response.data_hari_ini.length - 1;c >= 0;c--){
							data_ke[ctr] = urutan_data;
							array_suhu[ctr] = parseInt(response.data_hari_ini[c].suhu);
							array_kelembaban[ctr] = parseInt(response.data_hari_ini[c].rh);
							ctr++;
							urutan_data ++;
						}
						buat_grafik(array_suhu,array_kelembaban,urutan_data);
						
					}
				},
				error : function(response){
					console.log(response);
					
				},
			});
		}
		setInterval(function(){load_data();},5000);

		function buat_grafik(suhu,kelembaban,urutan_data){
			var chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container1'
				},
				title: {
					text: 'Grafik Data Suhu Harian (<?php echo date("F"); ?>)'
				},
				xAxis: {
					title: {
						enabled: true,
						text: 'Pengukuran ke - x'
					},
					categories: urutan_data
				},
				series: [{
					name: 'Suhu',
					data: suhu
				}]
			});

			var chart2 = new Highcharts.Chart({
				chart: {
					renderTo: 'container2'
				},
				title: {
					text: 'Grafik Data Kelembaban Harian (<?php echo date("F"); ?>)'
				},
				xAxis: {
					title: {
						enabled: true,
						text: 'Pengukuran ke - x'
					},
					categories: urutan_data
				},
				series: [{
					name: 'Kelembaban',
					color: '#00FF00',
					data: kelembaban
				}]
			});
		}

	});
	</script>