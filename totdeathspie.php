<?php
include('connect.php');
$negara = mysqli_query($connect, "SELECT * from tb_covid");
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['negara'];

	$query = mysqli_query($connect, "SELECT sum(total_deaths) as total_deaths from tb_covid where id='".$row['id']."'");
	$row = $query->fetch_array();
	$jumlah_negara[] = $row['total_deaths'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Total Deaths</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<center><h1>Total Deaths Covid 19 di 10 Negara</h1>
	<div id="canvas-holder" style="width:50%">
	<canvas id="chart-area"></canvas>
</div>
<script>
	var config = {
		type: 'pie',
		data: {
			datasets: [{
				data: <?php echo json_encode($jumlah_negara);
				?>,
				backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)',
				'rgba(210, 38, 30, 0.2)',
				'rgba(184, 136, 169, 0.2)',
				'rgba(47, 244, 79, 0.2)',
				'rgba(146, 32, 211, 0.2)',
				'rgba(152, 143, 152, 0.2)',
				'rgba(128, 8, 0, 0.2)'
				],
				borderColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(75, 192, 192, 1)',
				'rgba(210, 38, 30, 1)',
				'rgba(184, 136, 169, 1)',
				'rgba(47, 244, 79, 1)',
				'rgba(146, 32, 211, 1)',
				'rgba(152, 143, 152, 1)',
				'rgba(128, 8, 0, 1)'
				],
				label: 'Total Deaths'
			}],
			labels: <?php echo json_encode($nama_negara);?>},
			options: {
				responsive: true
			}
	};

	window.onload = function(){
	var ctx = document.getElementById('chart-area').getContext('2d');
	window.myPie = new Chart(ctx, config);
};

document.getElementById('randomizeData').addEventListener('click', function(){
	config.data.datasets.forEach(function(dataset){
		dataset.data = dataset.data.map(function(){
			return randomScallingFactor();
		});
	});
	window.myPie.update();
});

var colorNames = Object.keys(window.chartColors);
document.getElementById('addDataset').addEventListener('click', function(){
	var newDataset = {
		backgroundColor: [],
		data: [],
		label: 'New dataset' + config.data.datasets.length,
	};
	for (var index = 0; index < config.data.labels.length;
		index++){
		newDataset.data.push(randomScallingFactor());
	var colorName = colorNames[index % colorNames.length];
	var newColor = window.chartColors[colorName];
	newDataset.backgroundColor.push(newColor);
	}
	config.data.datasets.push(newDataset);
	window.myPie.update();
});

document.getElementById('removeDataset').addEventListener('click', function(){
	config.data.datasets.splice(0, 1);
	window.myPie.update();
});
</script>
</body>
</html>