<?php 
namespace App\Model;

use App\Model\Model;

class Bicicleta extends Model {
	
	private $table = "bicicletas";
	protected $fields = [
		"id_bicicleta",
		"nome_bicicleta",
		"url_amigavel_bicicleta",
		"data_cadastro_bicicleta",
		"descricao_bicicleta",
		"imagem_principal_bicicleta",
		"status_bicicleta"
	];

	function insertBicicleta($campos) {
		$this->insert($this->table, $campos);
	}

	function updateBicicleta($valores, $where) {
		$this->update($this->table, $valores, $where);
	}

	function deleteBicicleta($coluna, $valor) {
		$this->delete($this->table, $coluna, $valor);
	}

	function selectBicicleta($campos, $where):array {
		return $this->select($this->table, $campos, $where);
	}

	function getUltimoBicicleta() {
		$sql = "SELECT * FROM ".$this->table." ORDER BY id_bicicleta DESC LIMIT 1";
		return $this->querySelect($sql)[0];
	}

	function insertFotoGaleria($campos) {
		$this->insert('galeria_'.$this->table, $campos);
	}
	
	function selectBicicletasPage($limit, $offset) {
		$sql = "SELECT * FROM ".$this->table." ORDER BY id_bicicleta DESC LIMIT ".$offset.", ".$limit;

		return $this->querySelect($sql);
	}

	function selectByVendedor($vendedor) {
		$sql = "SELECT * FROM ".$this->table." WHERE vendedor_bicicleta = ".$vendedor."";

		return $this->querySelect($sql);
	}

	function selectGaleria($id):array {
		$sql = "SELECT * FROM galeria_".$this->table." WHERE id_bicicleta = ".$id;
		
		return $this->querySelect($sql);
	}

	function deleteImagemGaleria($nome, $id_bicicleta) {
		$sql = "DELETE FROM galeria_".$this->table." WHERE id_bicicleta = ".$id_bicicleta." AND caminho_imagem = '".$nome."'";
		$this->query($sql);
	}

	function selectBicicletasPesquisa($pesquisa, $vendedor) {
		$sql = "SELECT * FROM ".$this->table." WHERE nome_bicicleta LIKE '%".$pesquisa."%' and vendedor_bicicleta = ".$vendedor." ORDER BY id_bicicleta DESC";

		return $this->querySelect($sql);
	}
}