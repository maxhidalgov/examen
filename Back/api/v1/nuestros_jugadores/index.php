<?php

use back\api\v1\nuestros_jugadores\JugadorControlador;
use back\api\v1\nuestros_jugadores\JugadorModelo;

include_once '..\version1.php';

switch ($_method) {
    case 'GET':
        if ($_authorization === $_token_get) {
            $lista = [];
            include_once '..\conexion.php';
            include_once 'JugadorControlador.php';

            $controlador = new JugadorControlador();
            $lista = $controlador->getAll();
            http_response_code(200);
            echo json_encode(['data' => $lista]);
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }
        break;
    case 'POST':
        if ($_authorization === $_token_post) {

            include_once '..\conexion.php';
            include_once 'JugadorModelo.php';
            include_once 'JugadorControlador.php';

            $modelo = new JugadorModelo();
            $controlador = new JugadorControlador();
            $body = json_decode(file_get_contents('php://input', true));

            $modelo->setNombre($body->nombre);
            $modelo->setApellido($body->apellido);
            $modelo->setProfesion($body->profesion);
            $modelo->setPosicionId($body->posicion_id);
            $modelo->setActivo($body->activo);

            $respuesta = $controlador->add($modelo);
            if ($respuesta) {
                http_response_code(201);
                echo json_encode(['Creado' => 'Sin errores']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }
        break;
    case 'PUT':
        if ($_authorization == $_token_put) {

            include_once '..\conexion.php';
            include_once 'JugadorModelo.php';
            include_once 'JugadorControlador.php';

            $modelo = new JugadorModelo();
            $body = json_decode(file_get_contents('php://input', true));

            $modelo->setNombre($body->nombre);
            $modelo->setApellido($body->apellido);
            $modelo->setProfesion($body->profesion);
            $modelo->setPosicionId($body->posicion_id);
            $modelo->setActivo($body->activo);

            $controlador = new JugadorControlador();
            $lista = $controlador->getAll();
            $registro = new JugadorModelo();

            $existe = 0;
            foreach ($lista as $obj) {
                if ($obj['id'] == $_parametroID) {
                    $existe = 1;
                    $registro->setNombre($obj['nombre']);
                    $registro->setApellido($obj['apellido']);
                    $registro->setProfesion($obj['profesion']);
                    $registro->setPosicionId($obj['posicion_id']);
                    $registro->setActivo($obj['activo']);
                }
            }

            $cambios = 0;

            if ($registro->getNombre() != $modelo->getNombre()) {
                $cambios++;
            }
            if ($registro->getApellido() != $modelo->getApellido()) {
                $cambios++;
            }
            if ($registro->getProfesion() != $modelo->getProfesion()) {
                $cambios++;
            }
            if ($registro->getPosicionId() != $modelo->getPosicionId()) {
                $cambios++;
            }
            if ($registro->getActivo() != $modelo->getActivo()) {
                $cambios++;
            }

            if ($cambios == 0) {
                http_response_code(409);
                echo json_encode(['error' => 'No se actualizó el registro correspondiente al ID: ' . $_parametroID . '
                porque no hay cambios.']);
            } else {
                if ($existe) {
                    $respuesta = $controlador->update($modelo);
                    if ($respuesta) {
                        http_response_code(200);
                        echo json_encode(['Actualizado' => 'Sin errores, se realizó(ron): ' . $cambios . ' cambio(s).']);
                    } else {
                        http_response_code(416);
                        echo json_encode(['error' => 'No se actualizó el registro correspondiente al id: ' . $_parametroID]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe']);
                }
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }


        break;
    case 'PATCH':
        if ($_authorization === $_token_patch) {
            include_once '..\conexion.php';
            include_once 'JugadorModelo.php';
            include_once 'JugadorControlador.php';

            $modelo = new JugadorModelo();
            $controlador = new JugadorControlador();
            $lista = $controlador->getAll();

            $existe = 0;
            foreach ($lista as $obj) {
                if ($obj['id'] == $_parametroID) {
                    $existe = 1;
                    $modelo->setActivo($obj['activo']);
                }
            }

            if ($existe) {
                if (!$modelo->getActivo()) {
                    $modelo->setId($_parametroID);

                    $respuesta = $controlador->enable($modelo);

                    if ($respuesta) {
                        http_response_code(202);
                        echo json_encode(['Habilitado' => 'Sin errores']);
                    } else {
                        http_response_code(416);
                        echo json_encode(['error' => 'No se habilitó el registro correspondientre al id: '
                            . $_parametroID . ' porque ya estaba habilitado.']);
                    }
                } else {
                    http_response_code(409);
                    echo json_encode(['error' => 'No se habilitó el registro correspondiente al id:'
                        . $_parametroID . ' porque ya estaba habilitado.']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }
        break;
    case
    'DELETE':
        if ($_authorization === $_token_disable) {

            include_once '..\conexion.php';
            include_once 'JugadorModelo.php';
            include_once 'JugadorControlador.php';

            $modelo = new JugadorModelo();
            $controlador = new JugadorControlador();
            $lista = $controlador->getAll();

            $existe = 0;
            foreach ($lista as $obj) {
                if ($obj['id'] == $_parametroID) {
                    $existe = 1;
                    $modelo->setActivo($obj['activo']);
                }
            }

            if ($existe) {
                if ($modelo->getActivo()) {
                    $modelo->setId($_parametroID);

                    $respuesta = $controlador->disable($modelo);
                    if ($respuesta) {
                        http_response_code(202);
                        echo json_encode(['deshanilitado' => 'Sin errores']);
                    } else {
                        http_response_code(416);
                        echo json_encode(['error' => 'No se deshabilitó el registro correspondiente al id: '
                            . $_parametroID]);
                    }
                } else {
                    http_response_code(409);
                    echo json_encode(['error' => 'No se deshabilitó el registro correspondiente al id: '
                        . $_parametroID . ' porque ya esta deshabilitado']);
                }
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe']);
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }

        break;
    default:
        http_response_code(501);
        echo json_encode(['error' => 'No implementado']);
        break;

}
