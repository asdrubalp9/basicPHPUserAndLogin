<?php
class User{
	private $db;
	private $username;
	
	private $is_logged = false;
	private $msg = array();
	private $error = array();
	
	public function __construct($db) {
		
		session_start();
		$this->db = $db;
		$this->update_messages();
		
		if (isset($_GET['logout'])) {
			$this->logout();
		} elseif ( !empty($_SESSION['username']) && $_SESSION['is_logged'] )  {
			
			$this->is_logged = true;
			$this->username = $_SESSION['username'];

		} elseif (isset($_POST['login'])) {
			$this->login();
		}

		return $this;
	}
	
	public function get_username() { return $this->username; }
	
	
	
	public function is_logged() { return $this->is_logged; }
	
	public function get_info() { return $this->msg; }
	
	public function get_error() { return $this->error; }
	
	private function update_messages() {
		if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
			$this->msg = array_merge($this->msg, $_SESSION['msg']);
			$_SESSION['msg'] = '';
		}
		if (isset($_SESSION['error']) && $_SESSION['error'] != '') {
			$this->error = array_merge($this->error, $_SESSION['error']);
			$_SESSION['error'] = '';
		}
	}
	
	public function login() {
		
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$this->username = $this->db->real_escape_string($_POST['username']);
			$this->password = sha1($this->db->real_escape_string($_POST['password']));
			if ($row = $this->verify_password()) {
				session_regenerate_id(true);
				$_SESSION['id'] = session_id();
				$_SESSION['username'] = $this->username;
				$_SESSION['Nombres'] = $row->nombre.' '.$row->apellido;
				$_SESSION['is_logged'] = true;
				$this->is_logged = true;
				
				
				header('Location: admin.php');
				exit();
			} else $this->error[] = 'Usuario o clave equivocada.';
		} elseif (empty($_POST['username'])) {
			$this->error[] = 'El campo de nombre esta vacio.';
		} elseif (empty($_POST['password'])) {
			$this->error[] = 'El campo de clave esta vacio.';
		}
	}
	
	private function verify_password() {
		
		echo $query  = 'SELECT `id`, `userName`, `password`, `nombre`, `apellido`, `rut`, `direccion` FROM usuarios '
				. 'WHERE userName = "' . $this->username . '" '
				. 'AND password = "' . $this->password . '" ;';
		return ($this->db->query($query)->fetch_object());
	}
	
	public function logout() {
		session_unset();
		session_destroy();
		$this->is_logged = false;
		
		header('Location: index.php');
		exit();
	}
	
	public function register() {
		
		if (!empty($_POST['userName']) && !empty($_POST['password']) ) {
			
				
                $userName = $this->db->real_escape_string($_POST['userName']);
				$password = sha1($_POST['password']);
				$nombre = $this->db->real_escape_string($_POST['nombre']);
				$apellido = $this->db->real_escape_string($_POST['apellido']);
				$rut = $this->db->real_escape_string($_POST['rut']);
				$direccion = $this->db->real_escape_string($_POST['direccion']);
				echo $query  = '
				INSERT INTO `usuarios`( `userName`, `password`, `nombre`, `apellido`, `rut`, `direccion`)
									VALUES ("' . $userName . '","' . $password . '","' . $nombre . '","' . $apellido . '","' . $rut . '","' . $direccion . '")
									 ;';
				if ($this->db->query($query)) {
						$this->msg[] = 'El usuario ha sido creado.';
						$_SESSION['msg'] = $this->msg;
					}
					
					header('Location: admin.php');			
		} elseif (empty($_POST['userName'])) {
			$this->error[] = 'el campo de usuario esta vacio';
		} elseif (empty($_POST['password'])) {
			$this->error[] = 'el campo de clave esta vacio.';
		} elseif (empty($_POST['confirm'])) {
			$this->error[] = 'Necesita confirmar la clave.';
		}
	}

	public function update($username) {
		
		
		if (!empty($_POST['direccion']) ) {
			$this->direccion = $this->db->real_escape_string($_POST['direccion']);
			$username = $this->db->real_escape_string($username);
			echo $query  = '
							UPDATE `usuarios` SET `direccion` = "' . $this->direccion . '"  WHERE `userName` = "' . $username . '";';
			if ($this->db->query($query)) $this->msg[] = 'Su direccion se ha modificado exitosamente.';
			else $this->error[] = 'Hubo un error, por favor intente luego.';
		} 
		

		$_SESSION['msg'] = $this->msg;
		$_SESSION['error'] = $this->error;
		header('Location: ' . $_SERVER['REQUEST_URI']);
		
	}
	
	public function delete($user) {
		$query = 'DELETE FROM usuarios WHERE userName = "' . $user . '"';
		return ($this->db->query($query));
	}
	
	public function get_all_users() {
		$query = 'SELECT id, userName, password, nombre, apellido, rut, direccion FROM usuarios';
		return ($this->db->query($query)->fetch_all(MYSQLI_ASSOC));
	}
	
	public function display_info() {
		foreach ($this->msg as $msg) {
			echo '<p class="msg">' . $msg . '</p>';
		}
	}
	
	public function display_errors() {
		foreach ($this->error as $error) {
			echo '<p class="text-danger">' . $error . '</p>';
		}
	}
	
	
	
	
}
?>