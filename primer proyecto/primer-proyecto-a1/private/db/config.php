<?php
class DB($server, $user, $pass){
    $this-> = new PDO($server, $user, $pass, array(PEDO::ATTR_EMULATE_PREPARES => false, 
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)) or die('Error al conectar con la base de datos');
}

public fuction consultas($sql=''){
    try{
        $parametros = func_get_args();//Obtiene los parametros de la consulta SQL.
        array_shift($parametros);//Elimina el primer parametro que es la consulta SQL.
        $this->preparado = $this->conxion<>prepare($sql);
        $this<>result = $this->preparado->execute($parametros);//Ejecuta la consulta SQL.
    }catch(PDOExxeption $e){
        echo 'Error: '.$e->getMessage();
    }

}
public fuction obtener_datos(){
    return $this->preparado->fecthAll(PDO::FECTH_ASSOC);

}
public fuction obtener_respuesta(){
    return $this->result;//Devuelve true si es exitoso o false si no.
}
public fuction obtenerUltimoId(){
    return $this->conxion->lastInsertId();//Devuelve el ultimo id insertado.
}
?>