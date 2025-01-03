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
                j.id AS jug_id,
                CONCAT(j.nombre, ' ', j.apellido) AS jug_nombre_completo,
                j.profesion AS jug_profesion,
                jp.id AS pos_id,
                jp.nombre AS pos_nombre,
                jp.abreviado AS pos_abreviatura,
                MAX(jugador_datosextra.calificacion) AS calificacion,
                MAX(jugador_datosextra.foto) AS foto,
                GROUP_CONCAT(
                    JSON_OBJECT(
                        'rrss_nombre', rs.nombre,
                        'rrss_icono', rs.icono,
                        'rrss_valor', jr.valor
                    )
                    ORDER BY rs.id SEPARATOR ', '
                ) AS redes_sociales,
                j.activo as jug_activo
            FROM
                jugador j
            JOIN
                jugador_posicion jp ON j.posicion_id = jp.id
            LEFT JOIN
                jugador_rrss jr ON j.id = jr.jugador_id
            LEFT JOIN
                red_social rs ON jr.red_social_id = rs.id
            LEFT JOIN
                jugador_datosextra ON j.id = jugador_datosextra.jugador_id
            WHERE
                j.activo = TRUE
            GROUP BY
                j.id, j.nombre, j.apellido, j.profesion, jp.id, jp.nombre, jp.abreviado;
                    
                            ";
        
     
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                // Convertir 'activo' a booleano
                $tupla['activo'] = $tupla['jug_activo'] == 1 ? true : false;
    
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