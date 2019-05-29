<?php
  if(isset($_POST)){
    
  }
?>
    <form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">ingreso de usuarios</h1>
      <?php $user->display_errors(); ?>
      <label for="inputEmail" class="sr-only">
        Email address
      </label>
      <input name="username" type="text"   class="form-control" placeholder="Nombre de usuario" required autofocus>
      <label for="inputPassword" class="sr-only">
        Password
      </label>
      <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Clave" required>
      <button id="Singin" class="btn btn-lg btn-primary btn-block" name="login" type="submit">
        Ingresar
      </button>
      
    </form>
