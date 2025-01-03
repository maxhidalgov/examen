<?php

use back\api\v1\redes_sociales\RRSSControlador;
use back\api\v1\redes_sociales\RRSSModelos;

include_once '..\version1.php';

switch ($_method) {
    case 'GET':
        if ($_authorization === $_token_get) {
            $lista = [];
            include_once '..\conexion.php';
            include_once 'RRSSControlador.php';

            $controlador = new RRSSControlador();
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
            include_once 'RRSSModelos.php';
            include_once 'RRSSControlador.php';

            $modelo = new RRSSModelos();
            $controlador = new RRSSControlador();
            $body = json_decode(file_get_contents('php://input', true));

            $modelo->setNombre($body->nombre);
            $modelo->setIcono($body->icono);
            $modelo->setValor($body->valor);
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
            include_once 'RRSSModelos.php';
            include_once 'RRSSControlador.php';

            $modelo = new RRSSModelos();
            $body = json_decode(file_get_contents('php://input', true));

            $modelo->setId($_parametroID);
            $modelo->setNombre($body->nombre);
            $modelo->setIcono($body->icono);
            $modelo->setValor($body->valor);
            $modelo->setActivo($body->activo);

            $controlador = new RRSSControlador();
            $lista = $controlador->getAll();
            $registro = new RRSSModelos();

            $existe = 0;
            foreach ($lista as $obj) {
                if ($obj['id'] == $_parametroID) {
                    $existe = 1;
                    $registro->setNombre($obj['nombre']);
                    $registro->setIcono($obj['icono']);
                    $registro->setValor($obj['valor']);
                    $registro->setActivo($obj['activo']);
                }
            }

            $cambios = 0;

            if ($registro->getNombre() != $modelo->getNombre()) {
                $cambios++;
            }
            if ($registro->getIcono() != $modelo->getIcono()) {
                $cambios++;
            }
            if ($registro->getValor() != $modelo->getValor()) {
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
            include_once 'RRSSModelos.php';
            include_once 'RRSSControlador.php';

            $modelo = new RRSSModelos();
            $controlador = new RRSSControlador();
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
            include_once 'RRSSModelos.php';
            include_once 'RRSSControlador.php';

            $modelo = new RRSSModelos();
            $controlador = new RRSSControlador();
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