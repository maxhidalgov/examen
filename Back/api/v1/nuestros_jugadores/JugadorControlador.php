<?php

namespace back\api\v1\nuestros_jugadores;

class JugadorControlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new \conexion();
        $sql = "SELECT 
                    jugador.id, 
                    jugador.nombre, 
                    jugador.apellido, 
                    jugador.profesion, 
                    jugador.posicion_id, 
                    jugador.activo, 
                    jugador_posicion.nombre AS posicion_nombre, 
                    jugador_posicion.abreviado AS posicion_abreviado, 
                    jugador_datosextra.calificacion AS calificacion, 
                    jugador_datosextra.foto AS foto
                FROM jugador
                INNER JOIN jugador_posicion ON jugador.posicion_id = jugador_posicion.id
                LEFT JOIN jugador_datosextra ON jugador.id = jugador_datosextra.jugador_id;";
    
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                // Convertir 'activo' a booleano
                $tupla['activo'] = $tupla['activo'] == 1 ? true : false;
    
                // Agregar a la lista
                array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function add(JugadorModelo $_nuevo)
    {
        $con = new \conexion();
        $query = "insert into jugador(nombre, apellido, profesion, posicion_id, activo) 
                    values ('" . $_nuevo->getNombre() . "', '" . $_nuevo->getApellido() . "',
                     '" . $_nuevo->getProfesion() . "', '" . $_nuevo->getPosicionId() . "', 
                     '" . $_nuevo->getActivo() . "');";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function update(JugadorModelo $_registro)
    {
        $con = new \conexion();
        $query = "UPDATE jugador SET nombre = '" . $_registro->getNombre() . "', apellido = '" . $_registro->getApellido() . "',
                profesion = '" . $_registro->getProfesion() . "', posicion_id = '" . $_registro->getPosicionId() . "',
                    activo = '" . $_registro->getActivo() . "'
                     WHERE id = '" . $_registro->getId() . "';";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function disable(JugadorModelo $_registro)
    {
        $con = new \conexion();

        $query = "update jugador set activo = false where id = '" . $_registro->getId() . "';";
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function enable(JugadorModelo $_registro)
    {
        $con = new \conexion();

        $query = 'update jugador SET activo = true WHERE id = "' . $_registro->getId() . '";';
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }
}