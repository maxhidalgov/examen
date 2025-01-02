<?php

class Carousel
{
    private $id;
    private $imagen;
    private $titulo;
    private $descripcion;
    private $activo;

    public function __construct() {}
    //accesadores
    public function getId()
    {
        return $this->id;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getActivo()
    {
        return $this->activo;
    }
    //mutadores
    public function setId($_n)
    {
        $this->id = $_n;
    }
    public function setImagen($_n)
    {
        $this->imagen = $_n;
    }
    public function setTitulo($_n)
    {
        $this->titulo= $_n;
    }
    public function setDescripcion($_n)
    {
        $this->descripcion = $_n;
    }
    public function setActivo($_n)
    {
        $this->activo = $_n;
    }

    public function getAll()
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT id, imagen,titulo,descripcion, activo FROM carrusel;";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                //debemos trabajar con el objeto
                array_push($lista, $registro);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }


    public function add(Carousel $_nuevo)
    {
        $con = new Conexion();
    
        $query = "INSERT INTO carrusel (imagen, titulo, descripcion) 
                  VALUES ('" . $_nuevo->getImagen() . "', '" . $_nuevo->getTitulo() . "', '" . $_nuevo->getDescripcion() . "')";

        $rs = mysqli_query($con->getConnection(), $query);
    
        $con->closeConnection();
    
        if ($rs) {
            return true;
        }
        return false;
    }

    public function enable(Carousel $_registro)
    {
        $con = new Conexion();
        // Query para habilitar
        $query = "UPDATE carrusel SET activo = true WHERE id = " . $_registro->getId();
        // echo $query;
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function disable(Carousel $_registro)
    {
        $con = new Conexion();
        // Query para habilitar
        $query = "UPDATE carrusel SET activo = false WHERE id = " . $_registro->getId();
        // echo $query;
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }

    public function update(Carousel $_registro)
    {
        $con = new Conexion();
        // Query para habilitar
        $query = "UPDATE carrusel SET imagen = '" . $_registro->getImagen() . "', titulo = '". $_registro->getTitulo()."', descripcion = '".$_registro->getDescripcion()."' WHERE id = " . $_registro->getId();
        // echo $query;
        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }
}
