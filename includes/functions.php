<?php 


include "config.php";

if ($_POST["operation"] == "login") {
    $username = $_POST["username"];
    $pass     = $_POST["pass"];

    try {
        $stmt = $conn -> prepare(" SELECT nameU, role, pwd, active  FROM users WHERE username = ?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $stmt->bind_result($name, $role ,$password, $active);
        
        if ($stmt -> affected_rows) {
            $exists = $stmt -> fetch();

            if ($exists) {
                if ($password = $pass) {

                    if ($active == "1") {
                     
                        session_start();

                        $_SESSION["name"] = $name;
                        $_SESSION["role"] = $role;
    
                        $response = array(
                            'resp' => 'OK',
                            'message' => 'Inicio de Sesión Exitoso',
                            'url' => 'index.php'
                        );
                    } else {
                        $response = array(
                            'resp' => 'Error',
                            'message' => 'El usuario esta deshabilitado, contacta al Administrador',
                            'url' => 'index.php'
                        ); 
                    }
                } else {
                    $response = array(
                        'resp' => 'Error',
                        'message' => 'La contraseña es incorrecta',
                        'url' => 'index.php'
                    );
                }
            } else {
                $response = array(
                    'resp' => 'Error',
                    'message' => 'El usuario y/o contraseña son incorrectos',
                    'url' => 'index.php'
                );
            }

        } else {
            $response = array(
                'resp' => 'Error',
                'message' => 'No se encontraron datos en el Sistema',
                'url' => 'index.php'
            );
        }
    } catch (Exception $e) {
        $response = array(
            'resp' => 'Error',
            'message' => $e,
            'url' => 'index.php'
        );
    }

    die(json_encode($response));
}

if ($_POST["operation"] == "create") {
    $name       = $_POST["person"];
    $middle     = $_POST["middle"];
    $username   = $_POST["username-o"];
    $rol        = $_POST["role"];
    $pass       = $_POST["pass-o"];
    $active     = "1";
    
    
    try {
        $stmt = $conn -> prepare("INSERT INTO users(nameU, middleName, username, role, pwd, active)
                                 VALUES (?,?,?,?,?,?)");
 
         $stmt->bind_param("ssssss", $name, $middle, $username, $rol, $pass, $active);
         $stmt->execute();
 
         $id_inserted = $stmt->insert_id;
 
         if($id_inserted > 0) {
             $response = array(
                 'resp' => 'OK',
                 'message' => "Se ha insertado exitosamente",
                 'url' => "index.php"
             );
         } else {
             $response = array(
                 'resp' => 'Error',
                 'message' => "Hubo un error al intentar insertar el usuario",
                 'url' => "index.php"
             );
         }
 
    } catch (Exception $e) {
     $response = array(
         'resp' => 'Error',
         'message' => $e,
         'url' => "index.php"
     );
    }
    
    die(json_encode($response));
}

if ($_POST["operation"] == "read") {
    $id = $_POST["id"];

    try {
        $stmt = $conn -> prepare( "SELECT nameU, middleName, username, role, pwd FROM users WHERE idUser = ?" );
        $stmt -> bind_param("s", $id);
        $stmt -> execute();
        $stmt -> bind_result($name, $middle, $username, $role, $password);
        
        if ($stmt -> affected_rows) {
            $exists = $stmt -> fetch();
            if ($exists) {
                $response = array(
                    'resp' => 'OK',
                    'name' => $name,
                    'middle' => $middle,
                    'username' => $username,
                    'role' => $role,
                    'pass' => $password,
                    'id' => $id
                );
            } else {
                $response = array(
                    'resp' => 'Error',
                    'message' => 'Error'
                );
            }

        } else {
            $response = array(
                'resp' => 'Error',
                'message' => 'Error'
            );
        }

    } catch (Exception $e) {
        $response = array(
            'resp' => 'Error',
            'message' => $e
        );
    }

    die(json_encode($response));

} 

if ($_POST["operation"] == "update") {
    $name       = $_POST["person"];
    $middle     = $_POST["middle"];
    $username   = $_POST["username-o"];
    $rol        = $_POST["role"];
    $pass       = $_POST["pass-o"];
    $id         = $_POST["userId"];

    
    try {
        $stmt = $conn -> prepare("UPDATE users
                                SET nameU = ?, middleName = ?, username = ?, role = ?, pwd = ?
                                WHERE idUser = ?");
 
         $stmt->bind_param("ssssss", $name, $middle, $username, $rol, $pass, $id);
         $stmt->execute();
 
         if($stmt -> affected_rows) {
             $response = array(
                 'resp' => 'OK',
                 'message' => 'Se ha actualizado exitosamente',
                 'url' => "index.php"
             );
         } else {
             $response = array(
                 'resp' => 'Error',
                 'message' => 'Hubo un error',
                 'url' => "index.php"
             );
         }
 
    } catch (Exception $e) {
     $response = array(
         'resp' => 'Error',
         'message' => $e,
         'url' => "index.php"
     );
    }
    
    die(json_encode($response));
}

if ($_POST["operation"] == "updateStatus"){
    $id     = $_POST["id"];
    $active = $_POST["active"];

    $aux = $active == "0" ? "1" : "0";
    try {

        if ($active == "0") {
            $stmt = $conn -> prepare( "UPDATE users SET active = ? WHERE idUser = ?" );
            $stmt -> bind_param("ss", $aux, $id);
            $stmt -> execute();

            $response = array(
                'resp' => 'OK',
                'message' => 'Se ha habilitado este usuario'
            );

        } else {
            $stmt = $conn -> prepare( "UPDATE users SET active = ? WHERE idUser = ?" );
            $stmt -> bind_param("ss", $aux, $id);
            $stmt -> execute();

            $response = array(
                'resp' => 'OK',
                'message' => 'Se ha deshabilitado este usuario'
            );
        }

    } catch (Exception $e) {
        $response = array(
            'resp' => 'Error',
            'message' => $e
        );
    }

    die(json_encode($response));

}

if ($_POST["operation"] == "delete"){

    $id = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE idUser = ?");
        $stmt->bind_param("i", $id); 
        $stmt->execute();

        if ($stmt->affected_rows) {

            $response = array(
                'resp' => 'OK',
                'message' => 'El usuario se ha eliminado exitosamente',
                'url' => 'index.php'
            );

        } else {
            $response = array(
                'resp' => 'error',
                'message' => 'Hubo un error',
                'url' => 'index.php'
            );
        }            


    } catch (Exception $e) {
        $response = array(
            'resp' => $e->getMessage()
        );
    }

    die(json_encode($response));

}