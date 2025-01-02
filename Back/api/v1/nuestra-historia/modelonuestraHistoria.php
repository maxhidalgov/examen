<?php

class QuienesSomos
{
    private $id;
    private $texto;
    private $imagen;
    private $activo;


    public function __construct() {}

    // Accesadores
    public function getId()
    {
        return $this->id;
    }
    public function getTexto()
    {
        return $this->texto;
    }
    public function getImagen()
    {
        return $this->imagen;
    }
    public function getActivo()
    {
        return $this->activo;
    }

    // Mutadores
    public function setId($_n)
    {
        $this->id = $_n;
    }
    public function setTexto($_n)
    {
        $this->texto = $_n;
    }
    public function setImagen($_n)
    {
        $this->imagen = $_n;
    }
    public function setActivo($_n)
    {
        $this->activo = $_n;
    }

    // Obtener información de la sección "Quiénes Somos"
    // Obtener todos los registros de la tabla 'estilo_visual'
    public function getAll()
    {
        $lista = [];
        $con = new Conexion();
        $query = "SELECT id, texto, imagen, activo FROM nuestra_historia;";
        $rs = mysqli_query($con->getConnection(), $query);
        if ($rs) {
            while ($registro = mysqli_fetch_assoc($rs)) {
                // Convertir el campo 'activo' a booleano (true/false)
                $registro['activo'] = $registro['activo'] == 1 ? true : false;
                array_push($lista, $registro);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $lista;
    }

    // Modificar información de la sección "Quiénes Somos"

    public function update(QuienesSomos $_registro)
    {
        $con = new Conexion();
        $query = "UPDATE nuestra_historia
                  SET texto = '" . $_registro->getTexto() . "',
                      imagen = '" . $_registro->getImagen() . "'
                  WHERE id = " . (int)$_registro->getId();

        $rs = mysqli_query($con->getConnection(), $query);
        $con->closeConnection();
        if ($rs) {
            return true;
        }
        return false;
    }


        // Deshabilitar un registro (poner 'activo' en false)
        public function disable(QuienesSomos $_registro)
        {
            $con = new Conexion();
            $query = "UPDATE nuestra_historia SET activo = false WHERE id = " . (int)$_registro->getId();
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
            return false;
        }
    
        // Habilitar un registro (poner 'activo' en true)
        public function enable(QuienesSomos $_registro)
        {
            $con = new Conexion();
            $query = "UPDATE nuestra_historia SET activo = true WHERE id = " . (int)$_registro->getId();
            $rs = mysqli_query($con->getConnection(), $query);
            $con->closeConnection();
            if ($rs) {
                return true;
            }
            return false;
        }

        public function add(QuienesSomos $_nuevo)
        {
            $con = new Conexion();
        
            $query = "INSERT INTO nuestra_historia (texto, imagen) 
                      VALUES ('" . $_nuevo->getTexto() . "', '" . $_nuevo->getImagen() . "')";
            
            $rs = mysqli_query($con->getConnection(), $query);
        
            $con->closeConnection();
        
            if ($rs) {
                return true;
            }
            return false;
        }

        
}
