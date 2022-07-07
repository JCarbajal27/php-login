<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['color'])) {
    $sql = "INSERT INTO users (email, password, color) VALUES (:email, :password, :color)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->bindParam(':color', $_POST['color']);

    if ($stmt->execute()) {
      $message = 'Nuevo Usuario Creado';
    } else {
      $message = 'Hubo un error al crear tu cuenta';
    }
  }
?>
<style>

  select {
    outline: none;
    padding: 20px;
    display: block;
    width: 300px;
    border-radius: 3px;
    border: 1px solid #eee;
    margin: 20px auto;
  }

</style>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrarse</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Registrarse</h1>
    <span>O <a href="login.php">Iniciar Sesion</a></span>

    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Introduce tu Email" require>
      <input name="password" type="password" placeholder="Introduce tu Contraseña" require>
      
      <select name="color" type="text" >
        <option value="rojo">Rojo</option>
        <option value="azul">Azul</option>
        <option value="verde">Verde</option>
        <option value="amarillo">Amarillo</option>
      </select>
      
      <input type="submit" value="Enviar">
    </form>

  </body>
</html>
