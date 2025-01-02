<?php

namespace back\api\v1\proximos_entrenamientos;

class ProximosControlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new \conexion();
        $sql = "
        SELECT 
            entrenamientos_proximos.id, 
            entrenamientos_proximos.fecha, 
            entrenamientos_proximos.hora, 
            entrenamientos_proximos.entrenamiento_lugar_id, 
            entrenamiento_lugar.nombre AS entrenamiento_lugar_nombre, 
            entrenamientos_proximos.activo
        FROM 
            entrenamientos_proximos
        JOIN 
            entrenamiento_lugar 
        ON 
            entrenamientos_proximos.entrenamiento_lugar_id = entrenamiento_lugar.id;
            ";
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                $tupla['activo'] = $tupla['activo'] == 1 ? true : false;
                array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function add(ProximosModelos $_nuevo)
    {
        $con = new \conexion();
        $query = "insert into entrenamientos_proximos (fecha, hora, entrenamiento_lugar_id, activo)
                    values ('" . $_nuevo->getFecha() . "', '" . $_nuevo->getHora() . "', 
                    '" . $_nuevo->getEntrenamientoLugarId() . "', '" . $_nuevo->getActivo() . "');";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function update(ProximosModelos $_registro)
    {
        /*update entrenamientos_proximos set fecha = '05/01/2025', hora = '19:00 - 21:00', entrenamiento_lugar_id = '1' where id = 8;*/
        $con = new \conexion();
        $query = "update entrenamientos_proximos set fecha = '" . $_registro->getFecha() . "', hora = '" . $_registro->getHora() . "',
                    entrenamiento_lugar_id = '". $_registro->getEntrenamientoLugarId() ."', activo = '" . $_registro->getActivo() . "'
                     WHERE id = '" . $_registro->getId() . "';";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function disable(ProximosModelos $_registro)
    {
        $con = new \conexion();

        $query = "update entrenamientos_proximos set activo = false where id = '" . $_registro->getId() . "';";
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function enable(ProximosModelos $_registro)
    {
        $con = new \conexion();

        $query = 'update entrenamientos_proximos SET activo = true WHERE id = "' . $_registro->getId() . '";';
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

}