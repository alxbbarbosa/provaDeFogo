<?php

class Grade
{
    private $nome;
    private $titulo;
    private $dados;
    private $nomeColunas;
    private $classController;
    private $acaoAdicionar;
    private $acaoAlterar;
    private $acaoExcluir;
    private $acaoVoltar;
    private $colunaId;
    private $param;

    public function __construct(string $nome, string $titulo)
    {
        $this->nome   = $nome;
        $this->titulo = $titulo;
    }

    public function setClassController(string $class)
    {
        $this->classController = $class;
    }

    public function setAcaoAdicionar(string $acao)
    {
        $this->acaoAdicionar = $acao;
    }

    public function setAcaoAlterar(string $acao)
    {
        $this->acaoAlterar = $acao;
    }

    public function setAcaoExcluir(string $acao)
    {
        $this->acaoExcluir = $acao;
    }

    public function setAcaoVoltar(string $acao)
    {
        $this->acaoVoltar = $acao;
    }

    public function setColunaId(string $colunaId)
    {
        $this->colunaId = $colunaId;
    }

    public function setNomeParamsLinks(string $nome)
    {
        $this->param = $nome;
    }

    public function setDados(array $dados)
    {
        if (count($dados) > 0) {
            
            if (is_object($dados[0]) && method_exists($dados[0], 'toArray')) {

                $this->nomeColunas = array_keys($dados[0]->toArray());
            } else {
                $this->nomeColunas = array_keys((array) $dados[0]);
            }
            
            foreach ($dados as $linha) {
                if (is_object($linha) && method_exists($linha, 'toArray')) {
                    $this->dados[] = $linha->toArray();
                } else if (is_object($linha)) {
                    $this->dados[] = (array) $linha;
                } else {
                    $this->dados[] = $linha;
                }
            }
        }
    }

    public function render()
    {

        if (count($this->nomeColunas)) {
            $str = "<table name='{$this->nome}' class='table table-striped' >".PHP_EOL;
            $str .= "<tr>".PHP_EOL;

            for ($i = 0; $i < count($this->nomeColunas); $i++) {
                $str .= "<th>{$this->nomeColunas[$i]}<th>".PHP_EOL;
            }

            $str .= "<th><a href='?class={$this->classController}&method={$this->acaoAdicionar}' class='btn btn-primary'><span class='glyphicon glyphicon-plus'></span> Adicionar</a></th>".PHP_EOL;
            $str .= "<th><a href='?class={$this->classController}&method={$this->acaoVoltar}' class='btn btn-outline-primary'><span class='glyphicon glyphicon-log-out'></span> Voltar</a></th>".PHP_EOL;
            $str .= "</tr>".PHP_EOL;

            foreach ($this->dados as $linha) {
                $id  = 0;
                $str .= "<tr>".PHP_EOL;
                foreach ($linha as $nome => $celula) {
                    $str .= "<td>{$celula}<td>".PHP_EOL;
                    if ($nome == $this->colunaId) {
                        $id = (int) $celula;
                    }
                }
                $parametro = ($this->param != NULL || $this->param != '') ? $this->param : 'param';
                $str       .= "<td><a href='?class={$this->classController}&method={$this->acaoAlterar}&{$parametro}={$id}' class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span> Alterar</a></td>".PHP_EOL;
                $str       .= "<td><a href='?class={$this->classController}&method={$this->acaoExcluir}&{$parametro}={$id}' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Excluir</a></td>".PHP_EOL;
                $str       .= "<tr>".PHP_EOL;
            }
            $str .= "</table>".PHP_EOL;
        } else {

            $str = "<script>";
            $str .= "alert(\"Não encontrado registros para listar\");";
            $str .= "</script>";
            $str .= "<a href='?class={$this->classController}&method={$this->acaoVoltar}' class='btn btn-outline-primary'><span class='glyphicon glyphicon-log-out'></span> Voltar</a>".PHP_EOL;
        }
        echo $str;
    }
}