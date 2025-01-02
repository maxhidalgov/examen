<?php

namespace back\api\v1\proximos_entrenamientos;

class ProximosModelos
{
    private $id;
    private $fecha;
    private $hora;
    private $entrenamientoLugarId;
    private $activo;

    public function __construct()
    {
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    public function getEntrenamientoLugarId()
    {
        return $this->entrenamientoLugarId;
    }
    public function setEntrenamientoLugarId($entrenamientoLugarId)
    {
        $this->entrenamientoLugarId = $entrenamientoLugarId;
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