<?php



class UsuarioModel {
	private $pdo;

	public function __CONSTRUCT() {
		try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=u155011905_contabilidad', 'u155011905_lmzt', '0w1A~Fuyz=H');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Listar() {
		try {
			$result = array();

			$stm = $this->pdo->prepare("SELECT * FROM usuarios ORDER BY id DESC");
			$stm->execute();

			foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
				$user = new Usuario();

				//INFORMACION DEL USUARIO
				$user->__SET('id', $r->id);
				$user->__SET('doc_identidad', $r->doc_identidad);
				$user->__SET('nombres', $r->nombres);
				$user->__SET('apellidos', $r->apellidos);
				$user->__SET('email', $r->email);
				$user->__SET('usuario', $r->usuario);
				$user->__SET('contrasena', $r->contrasena);
				$user->__SET('rol', $r->rol);


				$result[] = $user;
			}
			return $result;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function Obtener($id) {
		try {
			$stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");


			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$user = new Usuario();
			//INFORMACION DEL USUARIO
			$user->__SET('id', $r->id);
			$user->__SET('doc_identidad', $r->doc_identidad);
			$user->__SET('usuario', $r->usuario);
			$user->__SET('email', $r->email);
			$user->__SET('nombres', $r->nombres);
			$user->__SET('apellidos', $r->apellidos);
			$user->__SET('contrasena', $r->contrasena);
			$user->__SET('rol', $r->rol);


			return $user;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function Eliminar($id) {

		try {
			$stm = $this->pdo->prepare("DELETE FROM usuarios WHERE id = ?");

			$stm->execute(array($id));
		} catch (Exception $e) {

			die($e->getMessage());
		}
	}

	public function Actualizar(Usuario $data) {

		try {
			$sql = "UPDATE usuarios SET

			doc_identidad		= ?,
			usuario		 		= ?,
			email				= ?,
			nombres				= ?,
			apellidos			= ?,
			contrasena   		= ?,
			rol		    		= ?,


			WHERE id = ?";

			$this->pdo->prepare($sql)->execute(
				array(

					//INFORMACION DEL USUARIO
					$data->__GET('doc_identidad'),
					$data->__GET('usuario'),
					$data->__GET('email'),
					$data->__GET('nombres'),
					$data->__GET('apellidos'),
					$data->__GET('contrasena'),
					$data->__GET('rol'),
					$data->__GET('id')


				)

			);
		} catch (Exception $e) {

			die($e->getMessage());
		}
	}

	/**
	 * Consulta la base de datos para verificar si un documento de identidad ya está registrado.
	 *
	 * @param string $doc_identidad Número de documento de identidad a verificar.
	 *
	 * @return bool Devuelve true si el documento no está duplicado, o false si ya existe en la base de datos.
	 */
	public function consultarDoc($doc_identidad): bool {
		try {
			// Preparar una consulta para contar la cantidad de registros con el mismo número de documento
			$stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM usuarios WHERE doc_identidad = ?");

			// Ejecutar la consulta con el número de documento como parámetro
			$stmt->execute([$doc_identidad]);

			// Obtener el resultado de la consulta como un arreglo asociativo
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			// Verificar si el número de documento ya está registrado en la base de datos
			if ($result['count'] > 0) {
				// El documento ya existe, detener el proceso y retornar false
				return false;
			} else {
				// El documento no está duplicado, continuar con el proceso y retornar true
				return true;
			}
		} catch (Exception $e) {
			// Manejar la excepción si ocurre, establecer el código de respuesta HTTP 500 y retornar false
			http_response_code(500);
			return false;
		}
	}

	public function Registrar(Usuario $data) {


		try {
			$sql = "INSERT INTO usuarios (id, doc_identidad, usuario, email, nombres, apellidos, contrasena, rol) VALUES (?,?,?,?,?,?,?,?)";

			$this->pdo->prepare($sql)->execute(
				array(

					//INFORMACION DEL USUARIO
					null,
					$data->__GET('doc_identidad'),
					$data->__GET('usuario'),
					$data->__GET('email'),
					$data->__GET('nombres'),
					$data->__GET('apellidos'),
					$data->__GET('contrasena'),
					$data->__GET('rol'),
				)
			);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}



	public function Imprimir($id) {
			$this->pdo = new PDO('mysql:host=localhost;dbname=u155011905_contabilidad', 'u155011905_lmzt', '0w1A~Fuyz=H');
		$result            = $mysqli_connection->query("SELECT * FROM usuarios WHERE id = '$id'");
		$mysqli_connection->close();
	}


	public function historial($id) {
		try {
			$stm = $this->pdo
				->prepare("SELECT * FROM histl_usuarios WHERE id = ?");


			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$userhistory = new Usuarioh();
			//INFORMACION DEL USUARIO
			$userhistory->__SET('id', $r->id);
			$userhistory->__SET('doc_identidad', $r->doc_identidad);
			$userhistory->__SET('usuario', $r->usuario);
			$userhistory->__SET('email', $r->email);
			$userhistory->__SET('nombres', $r->nombres);
			$userhistory->__SET('apellidos', $r->apellidos);
			$userhistory->__SET('contrasena', $r->contrasena);
			$userhistory->__SET('rol', $r->rol);



			return $userhistory;
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
