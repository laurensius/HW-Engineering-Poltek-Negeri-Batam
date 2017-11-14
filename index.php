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
								<tr class="info">
									<td><span class="glyphicon glyphicon-home"></span><a href="./index.php" style="text-decoration:none;"> Home</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-th-list"></span><a href="./tables.php" style="text-decoration:none;"> Tabel</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-stats"></span><a href="./stats.php" style="text-decoration:none;"> Statistik</td>
								</tr>
							</tbody>
						</table>
  					</div>
				</div>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Suhu (&degC)</p></center></td>
					</thead>
					<tr class="success">
						
						<td><center><p class="tebel gede" style="margin-top:5px" id="suhu"></p></center></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Kelembaban (%)</p></center></td>
					</thead>
					<tr class="info">
						<td><center><p class="tebel gede" style="margin-top:5px" id="rh"></p></center></td>
					</tr>
				</table>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				<p class="tebel">Ringkasan Data:</p>
					<table class="table table-striped table-hover">
						<tr>
							<td>Last Update</td>
							<td>:</td>
							<td><b><span id="last_update"></b></span></td>
						</tr>
						<!-- <tr>
							<td>Interval Update</td>
							<td>:</td>
							<td>10 menit</td>
						</tr> -->
						<tr>
							<td>Jumlah Data</td>
							<td>:</td>
							<td><b><span id="jumlah_data"></b></td>
						</tr>
					</table>
			</div>
			
		</div>
    </div>
	</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	<script>
	$(document).ready(function(){
		function load_recent(){
			$.ajax({
				url : 'loader.php?mode=recent' ,
				type : 'GET',
				dataType : 'json',
				success : function(response){
					console.log(response);
					$("#suhu").html(response.data_terakhir.suhu);
					$("#rh").html(response.data_terakhir.rh);
					$("#last_update").html(response.data_terakhir.datetime);
					$("#jumlah_data").html(response.jumlah_data.jumlah);
				},
				error : function(response){
					console.log(response);
					$("#suhu").html("Error");
					$("#rh").html("Error");
					$("#last_update").html("Error");
					$("#jumlah_data").html("Error");
				},
			});
		}
		setInterval(function(){load_recent();},1000);
	});
	</script>
	
</html>
