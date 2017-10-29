<?php

class Formulario
{
    private $nome;
    private $titulo;
    private $action;
    private $campos = array();
    private $methodCancelar;
    private $classCancelar;
    private $iconeSubmit;
    private $textoSubmit;

    public function __construct(string $nome, string $titulo)
    {
        $this->nome   = $nome;
        $this->titulo = $titulo;
    }

    public function setAction(string $action)
    {
        $this->action = $action;
    }

    public function setActionCancelar(string $class, string $method)
    {
        $this->classCancelar  = $class;
        $this->methodCancelar = $method;
    }

    public function adicionaCampo(iCampos $campo)
    {
        $this->campos[] = $campo;
    }

    public function alterarBotaoSubmit(string $rotulo, string $icone = ''): bool
    {
        $this->textoSubmit = $rotulo;
        if ($icone != '') {
            $this->iconeSubmit = $icone;
        }
        return true;
    }

    public function render()
    {
        $str = "<div class='panel panel-default' style='margin: 40px'>".PHP_EOL;
        $str .= "<div class='panel-heading' >{$this->titulo}</div>".PHP_EOL;
        $str .= "<div class='panel-body'>".PHP_EOL;
        $str .= "<form action='{$this->action}' name='{$this->name}' method='POST' class='form-horizontal'>".PHP_EOL;
        foreach ($this->campos as $campo) {
            $str .= $campo->getHTML();
        }
        $str         .= "<div class='form-group'>".PHP_EOL;
        $str         .= "<div class='col-sm-offset-2 col-sm-8'>".PHP_EOL;
        $textoSubmit = ($this->textoSubmit != NULL || $this->textoSubmit != '') ? $this->textoSubmit : 'Salvar';
        $iconeSubmit = ($this->iconeSubmit != NULL || $this->iconeSubmit != '') ? $this->iconeSubmit : 'glyphicon glyphicon-ok';
        $str         .= "<button type='submit' class='btn btn-success'><i class='{$iconeSubmit}'></i> {$textoSubmit}</button>".PHP_EOL;
        $str         .= "<a href='?class={$this->classCancelar}&method={$this->methodCancelar}' class='btn btn-info' /><span class='glyphicon glyphicon-remove'></span> Cancelar</a><br />".PHP_EOL;
        $str         .= "</div>".PHP_EOL;
        $str         .= "</div>".PHP_EOL;
        $str         .= "</form>".PHP_EOL;
        $str         .= "</div>".PHP_EOL;
        $str         .= "</div>".PHP_EOL;
        $str         .= "</div>".PHP_EOL;

        echo $str;
    }
}