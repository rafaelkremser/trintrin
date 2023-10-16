<?php 
namespace App\Model;

use App\Model\Model;

class Usuario extends Model {
	
	private $table = "usuarios";
	protected $fields = [
		"id_usuario",
		"nome_usuario",
		"email_usuario",
		"foto_usuario",
		"senha_usuario",
		"data_cadastro_usuario"
	];

	function insertUsuario($campos) {
		$this->insert($this->table, $campos);
	}

	function updateUsuario($valores, $where) {
		$this->update($this->table, $valores, $where);
	}

	function deleteUsuario($coluna, $valor) {
		$this->delete($this->table, $coluna, $valor);
	}

	function selectUsuario($campos, $where):array {
		return $this->select($this->table, $campos, $where);
	}

	public function selectNomeVendedor($vendedor) {
		$sql = "SELECT nome_usuario FROM ".$this->table." WHERE id_usuario = ".$vendedor."";
		return $this->querySelect($sql);
	}

	public static function verificarLogin()
	{
		if (!isset($_SESSION)) {
			session_start();
		}

		if (!isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === NULL) {
			header("Location: ".URL_BASE."admin-login");
			exit();
		}
	}
}