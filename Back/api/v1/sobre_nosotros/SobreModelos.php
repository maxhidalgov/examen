<?php

namespace back\api\v1\sobre_nosotros;

class SobreModelos
{
    private $id;
    private $logo_color;
    private $descripcion;
    private $activo;

    public function __construc()
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
    public function getLogoColor()
    {
        return $this->logo_color;
    }
    public function setLogoColor($logo_color)
    {
        $this->logo_color = $logo_color;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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