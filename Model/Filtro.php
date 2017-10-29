<?php

class Filtro {
	
	private $filtros = array();
	private $ordem_ordernar;
	
	public function __construct()
	{}
	
	public function adicionarFiltro(string $nomeCampo, string $operador, $valor)
	{
	    $this->filtros[] = array('nomeCampo' => $nomeCampo, 'operador' => $operador, 'valor' => $valor);
	}

	public function ordernarPor(string $nomeCampo, string $ordem_ordernar = '')
	{
		$this->ordem_ordernar = "ORDER BY {$nomeCampo}";
		
		if($ordem_ordernar != ''){
			
			if((strtoupper($ordem_ordernar) == 'ASC') || (strtoupper($ordem_ordernar) == 'DESC')){
				$this->ordem_ordernar .= ' ' . strtoupper($ordem_ordernar);
			}
		}
	}
	
	public function dump(): string
	{
		$contagem = count($this->filtros);
		
		$tmpDump = '';
		if($contagem > 0){
			$loop    = 1;
			$tmpDump .= ' WHERE ';
			foreach($this->filtros as $filtro){
				$is_like = (strtoupper($filtro['operador']) == 'LIKE');
				$tmpDump .= "{$filtro['nomeCampo']} {$filtro['operador']} " . $this->setTipo($filtro['valor'], $is_like);
				if($loop < $contagem){
					$tmpDump .= ' AND ';
				}
				$loop++;
			}
		}
		if($this->ordem_ordernar){
			$tmpDump .= ' '. $this->ordem_ordernar;
		}
		return $tmpDump;
	}
	
	private function setTipo($valor, bool $is_like)
	{
		if(is_string($valor) || is_int($valor)){
			$definido = $is_like? "'%{$valor}%'":"'{$valor}'";
		} else if(is_array($valor)) {
			foreach($valor as $elemento){
				if(is_string($elemento)) {
					$tmpVal[] = "'{$elemento}'";
				} else if(is_integer($elemento)) {
				    $tmpVal[] = $elemento;
				}
			}
			$definido = '(' . implode(',', $tmpVal) . ')';
		} else if (is_bool($valor)){
			$definido = $value ? 'TRUE' : 'FALSE';
		} else if (is_null($valor)){
			$definido = 'NULL';
		}
		return $definido;
	}
	
}