<?php

class CampoSelecao implements iCampos {
	
	private $nome;
	private $rotulo;
	private $opcoes;
	
	public function __construct($nome, $rotulo)
	{
		$this->nome   = $nome;
		$this->rotulo = $rotulo;
	}
	
	public function adicionaOpcao($valor, string $rotulo, bool $selecionar = FALSE)
	{
		$this->opcoes[] = array('valor' => $valor, 'rotulo' => $rotulo, 'selecionado' => $selecionar);
	}
	
	public function getHTML(): string
	{
	     $str  = "<div class='form-group'>" . PHP_EOL;
		 $str .= "<label class='col-sm-2 control-label'>{$this->rotulo}</label>" . PHP_EOL;
		 $str .= "<div class='col-sm-10'>" . PHP_EOL;
		 $str .= "<select name='{$this->nome}' class='selectpicker '>" . PHP_EOL;
		 foreach($this->opcoes as $opcao){
			 $str .= "<option value='{$opcao['valor']}'";
			 if($opcao['selecionado'] == TRUE){
			     $str .= " selected='selected'";	 
			 }
			 $str .= ">{$opcao['rotulo']}</option>" . PHP_EOL;
		 }
		 $str .= "</select>" . PHP_EOL;	
		 $str .= "</div>" . PHP_EOL;
		 $str .= "</div>" . PHP_EOL;
		
		return $str;
	}
}