<?php
include('connect.php');

$negara = mysqli_query($connect, "SELECT * from tb_covid");
while($row = mysqli_fetch_array($negara)){
  $nama_negara[] = $row['negara'];

  $query = mysqli_query($connect, "SELECT sum(total_recovered) as total_recovered from tb_covid where id='".$row['id']."'");
  $row = $query->fetch_array();
  $jumlah_negara[] = $row['total_recovered'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script type="text/javascript" src="Chart.js"></script>
</head>
<body>
  <center><h1>Total Recovered Covid 19 di 10 Negara</h1>
  <div style="width: 800px;height: 800px">
    <canvas id="myChart"></canvas>
  </div>


  <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($nama_negara); ?>,
        datasets: [{
          label: 'Grafik Total Recovered',
          data: <?php echo json_encode($jumlah_negara); ?>,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }
          }]
        }
      }
    });
  </script>
</body>
</html>