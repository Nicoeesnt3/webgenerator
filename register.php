<?php
    include("connection.php");
    session_start();
    if(isset($_SESSION['user'])){
        header("location: panel.php");
    }
    $msg = "";
    if(isset($_POST['btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $sql = "SELECT * FROM `usuarios` WHERE `email` = '$email'";
        $response =  mysqli_query($connection,$sql);
        $validation = true;
        if( !empty($response) AND  mysqli_num_rows($response) >= 1 ){
            $msg .= "El email que intenta registrar, ya existe";
            $validation = false;
        }

        if($password != $password1 ){
            $msg .= "Las contraseñas no coinciden";  
            $validation = false;
        }

        if($password == "" OR $email == "" ){
            $msg .= "No deben haber campos vacíos";  
            $validation = false;
        }
        
        if($validation){
            $sql = "INSERT INTO `usuarios` (`email`,`password`) VALUES ('$email','$password')";
            $response =  mysqli_query($connection,$sql);
            if ($response) {
                $msg = "Se ha registrado";
                header("location: login.php");
            }else {
            echo "Error al registrarse" . mysqli_error($connection);
            }
        }
        
        echo $msg;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Registrarse es simple</h1>
<form method="POST" action="">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Contraseña">
    <input type="password" name="password1"  placeholder="Repetir contraseña">
    <button name="btn" value="registrate">Registrate</button>
</form>
</body>
</html>