<?php
    include("connection.php");
    $msg = "";
    $domainList = "";
    session_start();
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
        $domainList =  getDomainList($connection);
        if(isset($_POST['btn'])){
            $user = $_SESSION['user'];
            $web = $_POST['web'];
            if($web == "" ){
                $msg = "Debe ingresar una web";
            }else{
                $web = $user.$web;
                $sql = "SELECT dominio FROM `webs` WHERE `dominio` = '$web' ";
                $response =  mysqli_query($connection,$sql);
                if( mysqli_num_rows($response) >= 1){
                    $msg = "El dominio que intenta registrar ya está registrado";
                }else{
                    $sql = "INSERT INTO `webs` (`idUsuario`,`dominio`) VALUES('$user','$web')";
                    $response =  mysqli_query($connection,$sql);
                    if ($response) {
                        $msg = "La web ha sido registrada correctamente";
                        echo shell_exec("./wix.sh '$web' '$web' ");
                        $domainList =  getDomainList($connection);
                    }else {
                        echo "Surgió un error al registrar la web" . mysqli_error($connection);
                    }
                }
                
            }
        }

        if(isset($_POST['download'])){
            $folder = $_POST['download'];
            $zip = "$folder.zip";
            echo shell_exec( "zip -r ".$zip." ".$folder);
            $location = "location: ".$zip ;
            if(!header($location)){
                $msg = "El .zip no ha sido encontrado";
            }
        }
        
        if(isset($_POST['delete'])){
            $folder = $_POST['delete'];
            echo shell_exec(" rm -r ".$folder);
            $sql = "DELETE FROM `webs` WHERE `dominio` = '$folder'";
            $response =  mysqli_query($connection,$sql);
            if ($response) {
                $msg = "Se elimino con éxito";
                $domainList =  getDomainList($connection);
            }else{
                $msg = "Algo salió mal, error al eliminar la web";
            }
        }

    }else{
        echo $msg;
        header("location: login.php");
    }
    echo $msg;

    function getDomainList($connection){
        $domainList = "";
        if( $_SESSION['permissions'] == "admin"){
            $sql = "SELECT `dominio` FROM `webs`";
        }else{
            $user = $_SESSION['user'];
            $sql = "SELECT dominio FROM `webs` WHERE `idUsuario` = '$user' ";
        }

        $response =  mysqli_query($connection,$sql);
        if( mysqli_num_rows($response) >= 1){
            $domainList .= "<ol>";
            while( $row = mysqli_fetch_array($response,MYSQLI_ASSOC)){
                $domain =$row['dominio'];
                
                $domainList.=
                "<li>
                    <a href='".$domain."'>".$domain."</a>
                    <button name='download' value='".$domain."'>Descargar web</button>
                    <button  name='delete' value='".$domain."'>Eliminar</button>
                </li>";
            }  
            $domainList .= "</ol>";
        }
        return $domainList;
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
<h1>Bienvenido a tu panel !</h1>
<a href="logout.php">Cerrar sesión de <?php echo $_SESSION['user'] ?></a>
<form method="POST" action="">
    <label for="">Generar web de:</label>
    <input type="text" name="web" >
    <button name="btn" value="crearWeb">Crear web</button>
</form>
<h2>Lista de dominios:</h2>
<form action="" method="POST">
    <?php echo $domainList ?>
    
</form>

</body>
</html>