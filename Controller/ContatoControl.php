<?php

class ContatoControl
{

    public function __construct()
    {

    }

    public function criar(): bool
    {
        $form1 = new Formulario('formContato', 'Cadastro de Contatos');
        $form1->setAction('?class=ContatoControl&method=salvar');
        $form1->adicionaCampo(new CampoTexto('nome', 'Nome'));
        $form1->adicionaCampo(new CampoTexto('sobrenome', 'Sobrenome'));
        $form1->adicionaCampo(new CampoTexto('email', 'Email'));
        $form1->adicionaCampo(new CampoTexto('telefone', 'Telefone'));
        $form1->adicionaCampo(new CampoTexto('celular', 'Celular'));

        $form1->setActionCancelar('MenuControl', 'listar');
        $form1->render();
        return true;
    }

    public function atualizar(int $id): bool
    {
        try {

            $recordSet = Contato::carregar($id);
            $form1     = new Formulario('formContato', 'Atualizando cadastro do contato: '.$recordSet->getNome());
            $form1->setAction("?class=ContatoControl&method=salvar&id={$id}");
            $form1->adicionaCampo(new CampoTexto('nome', 'Nome', $recordSet->getNome()));
            $form1->adicionaCampo(new CampoTexto('sobrenome', 'Sobrenome', $recordSet->getSobrenome()));
            $form1->adicionaCampo(new CampoTexto('email', 'Email', $recordSet->getEmail()));
            $form1->adicionaCampo(new CampoTexto('telefone', 'Telefone', $recordSet->getTelefone()));
            $form1->adicionaCampo(new CampoTexto('celular', 'Celular', $recordSet->getCelular()));
            $form1->setActionCancelar('MenuControl', 'listar');
            $form1->render();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function salvar(int $id = NULL): bool
    {
        try {
            $contato = new Contato;
            $contato->setNome(filter_input(INPUT_POST, 'nome'));
            $contato->setSobrenome(filter_input(INPUT_POST, 'sobrenome'));
            $contato->setEmail(filter_input(INPUT_POST, 'email'));
            $contato->setTelefone(filter_input(INPUT_POST, 'telefone'));
            $contato->setCelular(filter_input(INPUT_POST, 'celular'));
            if ($id) {
                $contato->setId($id);
            }
            $contato->salvar();
            header('Location: ?class=MenuControl&method=listar');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function excluir(int $id): bool
    {
        try {
            $contato = Contato::carregar($id);
            $contato->destruir();
            header('Location: ?class=MenuControl&method=listar');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function pesquisar(): bool
    {
        $form1 = new Formulario('formContato', 'Pesquisar Contatos');
        $form1->setAction('?class=ContatoControl&method=listar');

        $selecaoCampo = new CampoSelecao('campo', 'Campo');
        $selecaoCampo->adicionaOpcao('nome', 'Nome');
        $selecaoCampo->adicionaOpcao('sobrenome', 'Sobrenome');
        $selecaoCampo->adicionaOpcao('email', 'Email');
        $selecaoCampo->adicionaOpcao('telefone', 'Telefone');
        $selecaoCampo->adicionaOpcao('celular', 'Celular');

        $form1->adicionaCampo($selecaoCampo);

        $selecaoOperador = new CampoSelecao('operador', 'Operação');
        $selecaoOperador->adicionaOpcao('=', 'Igual');
        $selecaoOperador->adicionaOpcao('LIKE', 'Como');
        $form1->adicionaCampo($selecaoOperador);

        $form1->adicionaCampo(new CampoTexto('valor', 'Valor'));
        $form1->setActionCancelar('MenuControl', 'listar');
        $form1->alterarBotaoSubmit('Pesquisar', 'glyphicon glyphicon-search');

        $form1->render();

        return true;
    }

    public function listar(): bool
    {
        try {
            $campo    = filter_input(INPUT_POST, 'campo');
            $operador = filter_input(INPUT_POST, 'operador');
            $valor    = filter_input(INPUT_POST, 'valor');

            if (isset($campo) && isset($operador) && isset($valor)) {
                $filtro    = new Filtro;
                $filtro->adicionarFiltro($campo, $operador, $valor);
                $resultSet = Contato::listar($filtro->dump());
            } else {
                $resultSet = Contato::listar();
            }

            $grade = new Grade('gradeContato', 'Listando Contatos');
            $grade->setClassController('ContatoControl');
            $grade->setAcaoAdicionar('criar');
            $grade->setAcaoAlterar('atualizar');
            $grade->setAcaoExcluir('excluir');
            $grade->setAcaoVoltar('voltar');
            $grade->setColunaId('id');
            $grade->setNomeParamsLinks('id');
            $grade->setDados($resultSet);
            $grade->render();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function voltar(): bool
    {
        header('Location: ?class=MenuControl&method=listar');
    }
}