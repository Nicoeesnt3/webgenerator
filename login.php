<?php
    include("connection.php");
    $msg = "";
    session_start();
    if(isset($_SESSION['user']) ){
        header("location: panel.php");
    }

    if(isset($_POST['btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT idUsuario FROM `usuarios` WHERE `email` = '$email' AND `password` = '$password'";
        $response =  mysqli_query($connection,$sql);
        if( mysqli_num_rows($response) == 1){
            while( $row = mysqli_fetch_array($response,MYSQLI_ASSOC)){
                $_SESSION['user'] = $row['idUsuario'];
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                $_SESSION['permissions'] = "user";
                if($email == "admin@server.com" && $password =="serveradmin" ){
                    $_SESSION['permissions'] = "admin";
                }
            }
            header("location: panel.php");
        }else{
            $msg = "Usuario y/o contraseña incorrecto";
        }
        echo $msg;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>webgenerator Nicolás Goso</title>
</head>
<body>
    <form method="POST">
        <input type="email" name="email"  placeholder="Email">
        <input type="password" name="password"  placeholder="Contraseña">
        <button name="btn" value="iniciarSesion">Iniciar sesión</button>
        <a href="register.php">¿Aún no tienes una cuenta? Regístrate</a>
    </form>
</body>
</html>