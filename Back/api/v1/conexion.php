<?php

class Conexion
{
    private $connection;
    private $host;
    private $username;
    private $password;
    private $db;
    private $port;
    private $server;

    public function __construct()
    {
        $this->server = $_SERVER['SERVER_NAME'];
        $this->connection = null;
        // $this->host = 'localhost';
        $this->host = '127.0.0.1';
        $this->port = 3306; //puerto por default de mysql
        $this->db = 'clinicat1_ipss_backend_t3_s70';
        $this->username = 'clinicat1_ipss_backend_t3_s70';
        $this->password = '';

        /*
        SQL: Crear la bd y la tabla

        -- Crear la base de datos
        CREATE DATABASE `clinicat1_ipss_backend_t3_s70`;

        -- Crear el usuario y asignarle una contraseña
        CREATE USER 'clinicat1_ipss_backend_t3_s70'@'localhost' IDENTIFIED BY '1pss_b4ck3nd';

        -- Asignar privilegios al usuario para la base de datos específica
        GRANT ALL PRIVILEGES ON `clinicat1_ipss_backend_t3_s70`.* TO 'clinicat1_ipss_backend_t3_s70'@'localhost';

        -- Aplicar los cambios de privilegios
        FLUSH PRIVILEGES;

        --
        -- Nos conectamos con el usuario recien creado.
        --

        -- Indicamos que se va a utilizar esta base de datos
        use clinicat1_ipss_backend_t3_s70;

        CREATE TABLE unidad_medida(
            id INT PRIMARY KEY,
            simbolo VARCHAR(5) NOT NULL,
            codigo VARCHAR(5) NOT NULL UNIQUE,
            nombre_singular VARCHAR(50) NOT NULL,
            nombre_plural VARCHAR(50) NOT NULL,
            activo BOOLEAN NOT NULL DEFAULT FALSE
        );

        INSERT INTO unidad_medida (id, simbolo, codigo, nombre_singular, nombre_plural, activo) VALUES (1, '$', 'CLP', 'Peso', 'Pesos', TRUE);

        CREATE TABLE indicador(
            id INT PRIMARY KEY,
            codigo VARCHAR(10) NOT NULL UNIQUE,
            nombre VARCHAR(50) NOT NULL UNIQUE,
            unidad_medida_id INT NOT NULL,
            valor  DECIMAL(7,2),
            activo BOOLEAN NOT NULL DEFAULT FALSE
        );

        INSERT INTO indicador (id, codigo, nombre, unidad_medida_id, valor, activo) VALUES
        (1, 'UF', 'Unidad de Fomento', 1, 37968.98, TRUE),
        (2, 'IVP', 'Indice de Valor Promedio', 1, 39443.16, TRUE),
        (3, 'dolar', 'Dolar Observado', 1, 945.87, TRUE);



        **************************************************** TABLAS PARA EVALUACION 3 *******************************
        	CREATE TABLE categorias(
			id INT AUTO_INCREMENT PRIMARY KEY,
			nombre VARCHAR(255) NOT NULL,
			activo INT NOT NULL
        );
        
			CREATE TABLE productos(
				id INT PRIMARY KEY,
				nombre VARCHAR(50) NOT NULL UNIQUE,
				categoria_id INT,
				categoria_nombre VARCHAR(255),
				activo BOOLEAN NOT NULL DEFAULT TRUE,
				FOREIGN KEY (categoria_id) REFERENCES categorias(id)
			);
        
			INSERT INTO categorias (id, nombre, activo) VALUES
			(1, 'Pescados', TRUE),
			(2, 'Mariscos',TRUE);

        
				INSERT INTO productos (id, nombre, categoria_id,categoria_nombre, activo) VALUES
				(1, 'Albacora', 1,'Pescados', TRUE), 
				(2, 'Merluza', 1,'Pescados', TRUE),   
				(3, 'Salmón', 1,'Pescados', TRUE), 
				(4, 'Corvina', 1,'Pescados', TRUE),
                (5, 'Reineta', 1,'Pescados', TRUE), 
				(6, 'Almejas', 2,'Mariscos', TRUE), 
				(7, 'Choritos', 2,'Mariscos', TRUE),
                (8, 'Camarones', 2,'Mariscos', TRUE),
				(9, 'Langosta', 2,'Mariscos', TRUE), 
				(10, 'Piures', 2,'Mariscos', TRUE),
                (11, 'Jaiba', 2,'Mariscos', TRUE);


         */
    }

    public function getConnection()
    {
        try {
            $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->db, $this->port);
            mysqli_set_charset($this->connection, 'utf8');
            if (!$this->connection) {
                throw new Exception("Error en la conexión: " . mysqli_connect_error());
            }
            return $this->connection;
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            die("Error al conectar a la base de datos.");
        }
    }

    public function closeConnection()
    {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}
