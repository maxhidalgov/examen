<?php

namespace back\api\v1\sobre_nosotros;

class SobreControlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new \conexion();
        $sql = "SELECT id, logo_color, descripcion, activo FROM sobre_nosotros;";

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

    public function add(SobreModelos $_nuevo)
    {
        $con = new \conexion();
        $query = "insert into sobre_nosotros(logo_color, descripcion, activo) 
                    values ('" . $_nuevo->getLogoColor() . "', '" . $_nuevo->getDescripcion() . "',
                     '" . $_nuevo->getActivo() . "');";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function update(SobreModelos $_registro)
    {
        $con = new \conexion();
        $query = "update sobre_nosotros set logo_color = '" . $_registro->getLogoColor() . "', descripcion = '" . $_registro->getDescripcion() . "',
                    activo = '" . $_registro->getActivo() . "'
                     WHERE id = '" . $_registro->getId() . "';";

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function disable(SobreModelos $_registro)
    {
        $con = new \conexion();

        $query = "update sobre_nosotros set activo = false where id = '" . $_registro->getId() . "';";
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function enable(SobreModelos $_registro)
    {
        $con = new \conexion();

        $query = 'update sobre_nosotros SET activo = true WHERE id = "' . $_registro->getId() . '";';
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }
}