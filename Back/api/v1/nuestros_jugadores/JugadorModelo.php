<?php

namespace back\api\v1\nuestros_jugadores;

class JugadorModelo
{
    private $id;
    private $nombre;
    private $apellido;
    private $profesion;
    private $posicion_id;
    private $activo;

    public function __contruct(){}

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function getApellido()
    {
        return $this->apellido;
    }
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function getProfesion()
    {
        return $this->profesion;
    }
    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;
    }
    public function getPosicionId()
    {
        return $this->posicion_id;
    }
    public function setPosicionId($posicion_id)
    {
        $this->posicion_id = $posicion_id;
    }
    public function getActivo()
    {
        return $this->activo;
    }
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

}