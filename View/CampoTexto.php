<?php

class CampoTexto implements iCampos {
	
	private $nome;
	private $rotulo;
	private $valor;
	
	public function __construct($nome, $rotulo, $valor = '')
	{
		$this->nome   = $nome;
		$this->rotulo = $rotulo;
		$this->valor  = $valor;
	}
	
	public function getHTML(): string
	{
	     $str  = "<div class='form-group'>" . PHP_EOL;
		 $str .= "<label class='col-sm-2 control-label'>{$this->rotulo}</label>" . PHP_EOL;
		 $str .= "<div class='col-sm-10'>" . PHP_EOL;
		 $str .= "<input type='text' name='{$this->nome}' value='{$this->valor}' class='form-control' />" . PHP_EOL;	
		 $str .= "</div>" . PHP_EOL;
		 $str .= "</div>" . PHP_EOL;
		
		return $str;
	
	}

}