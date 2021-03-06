<?php
include 'connexion.php';

$usuario = $_POST['usuario'];
$True = 1;
$False = 0;
//$usuario = "lapaz";

// Encontrar ID de hospital a partir de nombre de usuario
$queryHospital = "SELECT id FROM hospitales WHERE usuario = '$usuario'";

$resultadoHospital = $conexion ->query($queryHospital);

if(mysqli_num_rows($resultadoHospital)){
    $id_hospital = $resultadoHospital ->fetch_assoc()["id"];
    //echo $id_hospital;
}
else{
    throw new Exception("FATAL ERROR: Hospital not in our database");
}

// Seleccionar pedidos conectados de un hospital
$query = "SELECT * FROM pedidos_conectados WHERE id_hospital = '$id_hospital' AND enviado = '$True' AND recibido = '$False'";

$resultado = $conexion -> query($query);

while($fila = mysqli_fetch_assoc($resultado)){

    $fila['nombre_objeto'] = helper($fila['id_objeto']);
    $product[] = array_map('utf8_encode',$fila);
}

echo json_encode($product);
$conexion->close();

// Encontrar el nombre de un objeto en base a su ID
function helper($id){
	include 'connexion.php';

    $queryObjetos = "SELECT nombre FROM objetos WHERE id = '$id'";

    $resultadoObjetos = $conexion ->query($queryObjetos);

    if(mysqli_num_rows($resultadoObjetos)){
    $nombre_objeto = $resultadoObjetos ->fetch_assoc()['nombre'];
    }

    else{
        throw new Exception("Object not in our database");
}
$conexion->close();
return $nombre_objeto;
}

?>