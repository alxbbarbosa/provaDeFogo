<?php

class MenuControl {

	public function __construct()
	{}
	
	public function listar(): bool
    {
		$menu = new Menu;
        $menu->adicionaItem("LISTAR_CONTATOS", "?class=ContatoControl&method=listar", "glyphicon glyphicon-th-list");
		$menu->adicionaItem("ADICIONAR_CONTATO", "?class=ContatoControl&method=criar", "glyphicon glyphicon-file");
		$menu->adicionaItem("LOCALIZAR_CONTATOS", "?class=ContatoControl&method=pesquisar", "glyphicon glyphicon-search");
		$menu->render();
        return true;
    }

}