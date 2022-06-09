<?php
include('connect.php');

$negara = mysqli_query($connect, "SELECT * from tb_covid");
while($row = mysqli_fetch_array($negara)){
  $nama_negara[] = $row['negara'];

  $query = mysqli_query($connect, "SELECT sum(new_cases) as new_cases from tb_covid where id='".$row['id']."'");
  $row = $query->fetch_array();
  $jumlah_negara[] = $row['new_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script type="text/javascript" src="Chart.js"></script>
</head>
<body>
  <center><h1>Total New Cases Covid 19 di 10 Negara</h1>
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
          label: 'Grafik Kasus Baru',
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