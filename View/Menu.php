<?php

class Menu
{
    private $itens = array();

    public function __construct()
    {

    }

    public function adicionaItem(string $item, string $caminho, string $icone = '')
    {
        $this->itens[$item] = array('caminho' => $caminho, 'icone' => $icone);
    }

    public function render()
    {
        $str = "<div class='panel panel-default' style='margin: 40px'>".PHP_EOL;
        $str .= "<div class='panel-heading' >Menu</div>".PHP_EOL;
        $str .= "<div class='panel-body'>".PHP_EOL;
        $str .= "<div class='form-horizontal'>".PHP_EOL;

        foreach ($this->itens as $item => $dados) {
            $str .= "<div class='form-group'>".PHP_EOL;
            $str .= "<a href='{$dados['caminho']}' class='btn btn-primary btn-block' ><span class='{$dados['icone']}'></span> ".str_replace('_', ' ', $item)."</a>".PHP_EOL;
            $str .= "</div>".PHP_EOL;
        }

        $str .= "</div>".PHP_EOL;
        $str .= "</div>".PHP_EOL;
        $str .= "</div>".PHP_EOL;
        $str .= "</div>".PHP_EOL;
        $str .= "</div>".PHP_EOL;

        echo $str;
    }
}