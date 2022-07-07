<?php

  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }

  $conexion = mysqli_connect('localhost','root','','php_login_database');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js"></script>

<style>
 
 .center {
  margin-left: auto;
  margin-right: auto;
  }
  
</style>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>

  <body>
    
    <?php if(!empty($user)): ?>

      <a href="logout.php">
        Salir
      </a>
      
      <canvas id="chart1" style="width:100%;" height="100"></canvas>

      <table style="width:50%;" class="center" border="2" >
        <tr>
          <td>Correo</td>
          <td>color</td>	
        </tr>

        <?php 
          $sql = "SELECT * FROM users";
          $result = mysqli_query($conexion,$sql);
          
          while($mostrar = mysqli_fetch_array($result)){
              
            ?>
            
              <tr>
                <td><?php echo $mostrar["email"] ?></td>
                <td><?php echo $mostrar["color"] ?></td>
              </tr>

            <?php 
          }

        ?>
        
	    </table>

    <?php else: ?>
      <h1>Iniciar Sesion o Registrarse</h1>

      <a href="login.php">Iniciar Sesion</a> o
      <a href="signup.php">Registrarse</a>
    <?php endif; ?>
  </body>
</html>

<?php 
  $sql = "SELECT *,COUNT(color) AS total FROM users GROUP BY color";
  $resultChart = mysqli_query($conexion,$sql);
?>

<script>
  var ctx = document.getElementById("chart1");
  var data = {
          labels: [ 
          
            <?php foreach($resultChart as $d):?>
            
              "<?php echo $d["color"]; ?>", 
            
            <?php endforeach; ?>

          ],
          datasets: [{
              label: 'Colores',
              data: [
                
                <?php foreach($resultChart as $d):?>
            
                  "<?php echo $d["total"]; ?>", 
          
                <?php endforeach; ?>

              ],

              //backgroundColor: "#3898db",
              borderColor: "#9b59b6",
              borderWidth: 3
          }]
      };
  var options = {
          scales: {
              /*yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]*/
          }
      };
  var chart1 = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: options
  });

</script>