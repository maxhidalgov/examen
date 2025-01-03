<?php

namespace back\api\v1\redes_sociales;

class RRSSModelos
{
    private $id;
    private $nombre;
    private $icono;
    private $valor;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getIcono()
    {
        return $this->icono;
    }

    public function setIcono($icono)
    {
        $this->icono = $icono;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
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