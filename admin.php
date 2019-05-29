
<?php
    require_once('header.php');
    if ($user->is_logged()) {
        echo '
        <nav class="navbar navbar-expand-md navbar-dark  bg-dark">  
        <a class="navbar-brand" href="#">Hola '.$_SESSION['Nombres'].'.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">            
                        
                        
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php?logout">
                                Logout
                            </a>
                        </li>
                </ul>
            </div>
        </nav>
        ';
    }else{
        header('Location: index.php');
    }
    if(isset($_POST) && isset($_POST['opc'])){
        

        switch($_POST['opc']){
            case 'modify':
                $user->update($_POST['userName']);
            break;
            case 'delete':
                $user->delete($_POST['userName']);
            break;
            case 'add':
                $user->register();
            break;
        }
    }
    

  $usuarios = $user->get_all_users();
  $i = 0;
  

    echo '
        <div class="container-fluid mt-4">
        ';
         $user->display_info(); 
    	 $user->display_errors(); 
         echo '
            
            <div class="row">
                <div class="col-6 mx-auto d-block">
                <div class="card">
                <div class="card-header" id="heading'.++$i.'">
                    <h2 class="mb-0">                    
                            Agregar Usuario
                    </h2>
                </div>            
                    <div class="card-body text-left">
                        <form class="form-signin" action="'.$_SERVER['PHP_SELF'].'" method="POST">                            
                                <div class="form-group row">
                                    <b>Nombre de usuario:</b> 
                                    <input type="text" class="form-control" name="userName" value="" placeholder="Nombre de usuario">
                                </div>
                                <div class="form-group row">
                                    <b>Nombre:</b> 
                                    <input type="text" class="form-control" name="nombre" value="" placeholder="nombre">
                                </div>
                                <div class="form-group row">
                                    <b>apellido:</b> 
                                    <input type="text" class="form-control" name="apellido" value="" placeholder="apellido">
                                </div>
                                <div class="form-group row">
                                    <b>rut:</b> 
                                    <input type="text" class="form-control" name="rut" value="" placeholder="rut">
                                </div>
                                <div class="form-group row">
                                    <b>direccion:</b> 
                                    <input type="text" class="form-control" name="direccion" value="" placeholder="direccion">
                                </div>
                                <div class="form-group row">
                                     <b>Clave:</b> 
                                    <input type="text" class="form-control" name="password" value="" placeholder="clave">
                                </div>
                                <button class="btn btn btn-primary d-block mx-auto" name="opc" value="add" type="submit">
                                    Agregar
                                </button>
                                
                        </form>
                    </div>
                </div>
                <h1 class="text-center">
                        Usuarios registrados
                </h1>
    ';
    foreach( $usuarios as $user){
            
        echo '

            <div class="card">
                <div class="card-header" id="heading'.++$i.'">
                    <h2 class="mb-0">                    
                            '.$user['nombre'].' '.$user['apellido'].'
                    </h2>
                </div>            
                    <div class="card-body text-left">
                        <form class="form-signin" action="'.$_SERVER['PHP_SELF'].'" method="POST">                            
                            <div class="form-group row">
                                    <b>Rut:</b> '.$user['rut'].' 
                                </div>
                                <div class="form-group row">
                                    <b>Direccion:</b> 
                                    <input type="text" class="form-control" name="direccion" value="'.$user['direccion'].'" placeholder="direccion">
                                    <input type="hidden" class="form-control" name="userName" value="'.$user['userName'].'" >
                                </div>
                                <button class="btn btn btn-primary" name="opc" value="modify" type="submit">
                                    Modificar
                                </button>
                                <button class="btn btn btn-danger" name="opc" value="delete" type="submit">
                                    Borrar usuario
                                </button>
                        </form>
                    </div>
                
            </div>
        ';        
      }

  echo '
            </div>
        </div>
    </div>
  ';
  

  require_once('footer.php');

?>

