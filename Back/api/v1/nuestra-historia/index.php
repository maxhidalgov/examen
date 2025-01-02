<?php
include_once '../version1.php';

switch ($_method) {
    case 'GET':
        if ($_authorization === $_token_get) {
            $lista = [];
            // Llamamos al archivo que contiene la clase conexion
            include_once '../conexion.php';
            include_once 'modelonuestraHistoria.php';  // Modelo para la sección "Quiénes Somos"
            
            // Se realiza la instancia al modelo QuienesSomos
            $modelo = new QuienesSomos();
            $lista = $modelo->getAll();  // Obtener la información de "Quiénes Somos"

            http_response_code(200);
            echo json_encode(['data' => $lista]);
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'Prohibido']);
        }
        break;
    
        case 'POST':
            if ($_authorization === $_token_post) {
                include_once '../conexion.php';
                include_once 'modelonuestraHistoria.php';
                //se realiza la instancia al modelo EstiloVisual
                $modelo = new QuienesSomos();
                //se recuperan los datos RAW del body en formato JSON
                $body = json_decode(file_get_contents("php://input", true)); // json_decode -> transforma un JSON a un Objeto estándar para trabajar
                $modelo->setId($body->id);
                $modelo->setTexto($body->texto);
                $modelo->setImagen($body->imagen);

                //agrega el nuevo valor
                $respuesta = $modelo->add($modelo);
                if ($respuesta) {
                    http_response_code(201);
                    echo json_encode(['Creado' => 'Sin errores']);
                }
            } else {
                http_response_code(403);
                echo json_encode(['error' => 'Prohibido']);
            }
            break;
    
        case 'PATCH':
            if ($_authorization == $_token_patch) {
                include_once '../conexion.php';
                include_once 'modelonuestraHistoria.php';
                // Se instancia el modelo
                $modelo = new QuienesSomos();
    
                $lista = $modelo->getAll();
    
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
                        $respuesta = $modelo->enable($modelo);
                        if ($respuesta) {
                            http_response_code(202);
                            echo json_encode(['Habilitado' => 'Sin errores']);
                        } else {
                            http_response_code(416);
                            echo json_encode(['error' => 'No se habilitó el registro correspondiente al id: ' . $_parametroID]);
                        }
                    } else {
                        http_response_code(409);
                        echo json_encode(['error' => 'No se habilitó el registro correspondiente al id: ' . $_parametroID . ' porque ya estaba habilitado.']);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe.']);
                }
            } else {
                http_response_code(403);
                echo json_encode(['error' => 'Prohibido']);
            }
            break;

        case 'DELETE':
                if ($_authorization == $_token_disable) {
                    include_once '../conexion.php';
                    include_once 'modelonuestraHistoria.php';
                    // Se instancia el modelo
                    $modelo = new QuienesSomos();
        
                    $lista = $modelo->getAll();
        
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
                            $respuesta = $modelo->disable($modelo);
                            if ($respuesta) {
                                http_response_code(202);
                                echo json_encode(['deshabilitado' => 'Sin errores']);
                            } else {
                                http_response_code(416);
                                echo json_encode(['error' => 'No se deshabilitó el registro correspondiente al id: ' . $_parametroID]);
                            }
                        } else {
                            http_response_code(409);
                            echo json_encode(['error' => 'No se deshabilitó el registro correspondiente al id: ' . $_parametroID . ' porque ya estaba deshabilitado.']);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe.']);
                    }
                } else {
                    http_response_code(403);
                    echo json_encode(['error' => 'Prohibido']);
                }
        break;
    
        case 'PUT':
            if ($_authorization == $_token_put) {
                include_once '../conexion.php';
                include_once 'modelonuestraHistoria.php';
                $modelo = new QuienesSomos();
                $body = json_decode(file_get_contents("php://input", true)); // json_decode -> transforma un JSON a un Objeto estándar para trabajar
    
                $modelo->setId($_parametroID);
                $modelo->setTexto($body->texto);
                $modelo->setImagen($body->imagen);
                
                $lista = $modelo->getAll();
                $registroBD = new QuienesSomos();
    
                $existe = 0;
                foreach ($lista as $obj) {
                    if ($obj['id'] == $_parametroID) {
                        $existe = 1;
                        $registroBD->setTexto($obj['texto']);
                        $registroBD->setImagen($obj['imagen']);
                    }
                }
    
                $cambios = 0;
    
                if ($registroBD->getTexto() != $modelo->getTexto()) {
                    $cambios++;
                }
    
                if ($registroBD->getImagen() != $modelo->getImagen()) {
                    $cambios++;
                }
    
   
                if ($cambios == 0) {
                    http_response_code(409);
                    echo json_encode(['error' => 'No se actualizó el registro correspondiente al id: ' . $_parametroID . ' porque no hay cambios.']);
                } else {
                    if ($existe) {
                        $respuesta = $modelo->update($modelo);
                        if ($respuesta) {
                            http_response_code(202);
                            echo json_encode(['Actualizado' => 'Sin errores, se realizó(ron): ' . $cambios . ' cambio(s)']);
                        } else {
                            http_response_code(416);
                            echo json_encode(['error' => 'No se actualizó el registro correspondiente al id: ' . $_parametroID]);
                        }
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'El registro de id: ' . $_parametroID . ' no existe.']);
                    }
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


