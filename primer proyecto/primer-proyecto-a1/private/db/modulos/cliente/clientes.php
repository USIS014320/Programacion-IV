<?php
include('../../db/db.php');
class clientes{
    private $datos=[], $db;
    public $respuesta = ['msg'=>'correcto'];

    public fuction cliente($db=''){
        $this->db = $db;
    }
    public fuction recibir_datos($cliente=''){
        $this->datos = json_decode($cliente, true);
        $this->validar_datos();
    }
    private fuction validar_datos{
        if(empty(trim($this->datos['codigo'])) ){
            $this->respuesta['msg'] = 'El codigo es requerido';
        }
        if(empty(trim($this->datos['nombre'])) ){
            $this->respuesta['msg'] = 'El nombre es requerido';
        }
        if(empty(trim($this->datos['direccion'])) ){
            $this->respuesta['msg'] = 'La direccion es requerida';
        }
        if(empty(trim($this->datos['telefono'])) ){
            $this->respuesta['msg'] = 'El telefono es requerido';
        }
        if(empty(trim($this->datos['dui'])) ){
            $this->respuesta['msg'] = 'El dui es requerido';
        }
    }
    $this->almacenar_datos();
    
        private fuction almacenar_datos(){
            if($this->respuesta['msg'] == 'correcto'){
                if($this->datos['accion'] == 'nuevo'){
                    $this->consultas('INSERT INTO clientes(codigo, nombre, direccion, telefono, dui) 
                    VALUES(?, ?, ?, ?, ?)',
                     $this->datos['codigo'], $this->datos['nombre'], $this->datos['direccion'], 
                     $this->datos['telefono'], $this->datos['dui']
                    );
                    return $this->db->obtenerUltimoId();
                
            }else if($this->datos['accion'] == 'modificar'){
                $this->consultas('UPDATE clientes SET codigo=?, nombre=?, direccion=?, telefono=?, dui=? WHERE id=?',
                $this->datos['codigo'], $this->datos['nombre'], $this->datos['direccion'], 
                $this->datos['telefono'], $this->datos['dui'], $this->datos['id']
            );
            return $this->['idCliente'];
            }
                
            }else if($this->datos['accion'] == 'eliminar'){
                $this->consultas('DELETE FROM clientes WHERE id=?', $this->datos['id']);
                return $this->datos['idCliente'];
            }

            }else{
                returbn $this->respuesta;
            }
        }

}

?>
