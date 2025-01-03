<?php

namespace back\api\v1\redes_sociales;

class RRSSControlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new \conexion();
        $sql = "select id, nombre, icono, valor, activo from redes_sociales;";
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

    public function add(RRSSModelos $_nuevo)
    {
        $con = new \conexion();
        $query = "insert into redes_sociales (nombre, icono, valor, activo) 
                    values ('" . $_nuevo->getNombre() . "', '" . $_nuevo->getIcono() . "', '" . $_nuevo->getValor() . "',
                     '" . $_nuevo->getActivo() . "');";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function update(RRSSModelos $_registro)
    {
        $con = new \conexion();
        $query = "update redes_sociales set nombre = '" . $_registro->getNombre() . "', icono = '" . $_registro->getIcono() . "', 
                valor = '" . $_registro->getValor() . "', activo = '" . $_registro->getActivo() . "'
                     WHERE id = '" . $_registro->getId() . "';";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function disable(RRSSModelos $_registro)
    {
        $con = new \conexion();

        $query = "update redes_sociales set activo = false where id = '" . $_registro->getId() . "';";
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function enable(RRSSModelos $_registro)
    {
        $con = new \conexion();

        $query = 'update redes_sociales SET activo = true WHERE id = "' . $_registro->getId() . '";';
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }
}