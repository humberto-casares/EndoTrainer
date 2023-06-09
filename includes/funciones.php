<?php
function conectar(){
    global $host_mysql, $user_mysql , $pass_mysql,$db_mysql;
    $conx = mysqli_connect ($host_mysql, $user_mysql , $pass_mysql) or die ("No se pudo conectar al servidor…"); 
    mysqli_select_db ($conx, $db_mysql) or die ("No se pudo conectar a Base de Datos");
    return $conx;
}

function limpiar($var){
    htmlspecialchars($var);
    return $var;
}

function redir($var){
    ?>
    <script>
        window.location="<?=$var?>";
    </script>
    <?php
    die();
}

function alert($var){
    ?>
    <script type="text/javascript">
        alert("<?=$var?>");
    </script>
    <?php
}

function validar_admin(){
    if(!isset($_SESSION['id'])){
        redir("?p=admin");
    }
}

function validar_usuario($url){
     if(!isset($_SESSION['idCli'])){
         redir("?p=login&return=$url");
     }else{

     }
}

function nombre_cliente($id_cliente){
	$mysqli = conectar();

	$q = $mysqli->query("SELECT * FROM users WHERE idUser = '$id_cliente'");
    $r = mysqli_fetch_array($q);
    return $r['fullName'];
}

?>