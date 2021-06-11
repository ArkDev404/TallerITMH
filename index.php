<?php
    session_start();
    $title = "Taller: Desarrollo Web";
    include "template/header.php";

?>

<style>
    .btn {
        border-radius: 20px;
    }
</style>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand"><img src="https://image.flaticon.com/icons/png/512/1005/1005141.png" width="50"></a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?php 
                    if (empty($_SESSION["role"])) {
                        echo "<button class='btn btn-link text-white' type='button' data-toggle='modal' 
                                data-target='#my-modal'>Iniciar Sesión</button>";
                    } else {
                        echo "<a class='text-white' href='includes/sign-out.php'> Cerrar Sesión </a>" ;
                    }
                ?>
            </li>
        </ul>
    </div>
</nav>

<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Inicio de Sesión</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="username" style="font-weight: bold ;">Usuario:</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Ingresa aqui tu nombre de usuario">
                    </div>
                    <div class="form-group">
                        <label for="pass" style="font-weight: bold ;">Contraseña:</label>
                        <input type="password" class="form-control" id="pass" name="pass"
                            placeholder="Ingresa tu contraseña">
                    </div>
                    <input type="hidden" name="operation" value="login">
                    <button class="btn btn-primary" type="submit"> Ingresar </button>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="addEditUser" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Datos del Usuario</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Ingrese la información que se le solicita: </p>

                <form id="editAdd">
                    <div class="form-group">
                        <label for="person">Nombre: </label>
                        <input type="text" class="form-control" id="person" name="person"
                            placeholder="Ingresa el nombre">
                    </div>
                    <div class="form-group">
                        <label for="person">Apellidos: </label>
                        <input type="text" class="form-control" id="middle" name="middle"
                            placeholder="Ingresa los apellidos">
                    </div>
                    <div class="form-group">
                        <label for="person">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username-o" name="username-o"
                            placeholder="Ingresa el usuario">
                    </div>
                    <div class="form-group">
                        <label for="role">Roles</label>
                        <select id="role" class="form-control" name="role">
                                <option value="Administrador">Administrador</option>
                                <option value="Normal">Normal</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="person">Contraseña</label>
                        <input type="password" class="form-control" id="pass-o" name="pass-o"
                            placeholder="Ingresa la contraseña">
                    </div>

                    <div class="text-center">
                        <input type="hidden"  id="operation" name="operation" value="">
                        <input type="hidden"  id="userId" name="userId" value="">
                        <button class="btn btn-primary" type="submit"> <i class="fa fa-save"></i>  Guardar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == "Administrador") {
?>
<div class="container mt-5">
    <div class="text-center">
        <h3> <b>Bienvenido: </b> <?php  echo $_SESSION["name"]; ?> </h3>
        <h4>Lista de Usuarios</h4>
        <button class="btn btn-primary btn-lg" data-toggle='modal' id='openModal' data-target='#addEditUser'><i
                class="fa fa-user-plus"></i></button>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="data" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Permisos</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 

                    include "includes/config.php";

                    try {
                        $query = "SELECT * FROM users";
                        $result = $conn -> query($query);

                        while ($user = $result -> fetch_assoc()) {
                           
                            $active = $user['active'] == "1"  ?  "checked" : "" ;

                            echo "<tr>
                                    <td>".$user['idUser']."</td>
                                    <td>".$user['nameU']."</td>
                                    <td>".$user['middleName']."</td>
                                    <td>".$user['username']."</td>
                                    <td>".$user['role']."</td>
                                    <td>
                                        <div class='custom-control custom-switch'>
                                            <input type='checkbox' class='custom-control-input' id='toggle".$user['idUser']."' onClick='StatusUser(".$user['idUser'].")' ".$active.">
                                            <label class='custom-control-label' for='toggle".$user['idUser']."'></label>
                                        </div> 
                                    </td>
                                    <td>
                                        <button class='btn btn-warning text-white' onclick='EditUser(".$user['idUser'].")'> <i class='fa fa-user-edit'></i> </button>
                                        <button class='btn btn-danger' onclick='DeleteUser(".$user['idUser'].")' > <i class='fa fa-user-times'></i> </button>
                                    </td>
                                </tr>";
                        }
                    } catch (Exception $e) {

                    }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
    } else {
        echo "<h3 class='text-center'>No tienes privilegios para acceder a esta información</h3>";
    }
} else {
    echo "<h3 class='text-center mt-5'>Debes iniciar sesión para acceder a este sección</h3>";
} ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="js/app.js"></script>

<script>
$(document).ready(function() {
    $('#data').DataTable({
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "info": "Mostrando de _START_ a _END_ de _TOTAL_ entradas"
        }
    });
});
</script>
</body>

</html>