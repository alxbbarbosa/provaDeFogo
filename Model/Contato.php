<?php

class Contato
{
    const ERRO_CONEXAO = 'Não foi possivel executar a declaração SQL';

    private $id;
    private $nome;
    private $sobrenome;
    private $email;
    private $telefone;
    private $celular;

    /**
     * Método construtor que permite criar contato informado argumentos
     * @var string $nome Define o nome para contato
     * @var string $sobrenome Define o sobrenome para contato
     * @return boolean
     */
    public function __construct(string $nome = NULL, string $sobrenome = NULL)
    {
        if ($nome) {
            $this->nome = $nome;
        }

        if ($sobrenome) {
            $this->sobrenome = $sobrenome;
        }
    }

    /**
     * Método para inserir um id para contato
     * @var int $id Define o nome para contato
     * @return boolean
     */
    public function setId(int $id): bool
    {
        if ($id > 0) {
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para inserir um nome para contato
     * @var string $nome Define o nome para contato
     * @return boolean
     */
    public function setNome(string $nome): bool
    {
        if (strlen($nome) > 0) {
            $this->nome = $nome;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para inserir um sobrenome para contato
     * @var string $sobrenome Define o sobrenome para contato
     * @return boolean
     */
    public function setSobrenome(string $sobrenome): bool
    {
        if (strlen($sobrenome) > 0) {
            $this->sobrenome = $sobrenome;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para inserir um email para contato
     * @var string $email Define o email para contato
     * @return boolean
     */
    public function setEmail(string $email): bool
    {
        if (strlen($email) > 0) {
            $this->email = $email;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para inserir um telefone para contato
     * @var string $telefone Define o telefone para contato
     * @return boolean
     */
    public function setTelefone(string $telefone): bool
    {
        if (strlen($telefone) > 0) {
            $this->telefone = $telefone;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para inserir um celular para contato
     * @var string $celular Define o celular para contato
     * @return boolean
     */
    public function setCelular(string $celular): bool
    {
        if (strlen($celular) > 0) {
            $this->celular = $celular;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o nome
     * @return type
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Retorna sobrenome
     * @return type
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * Retorna email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Retorna Telefone
     * @return string
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Retorna celular
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Método salvar permite salvar o objeto no banco de dados
     * @return boolean
     */
    public function salvar(): bool
    {
        $conexao = Conexao::getInstancia('contatos');
        if ($this->id) {
            $stmt = $conexao->prepare("UPDATE tb_contatos SET nome=?, sobrenome=?, email=?, telefone=?, celular=? WHERE id=?");
            $stmt->bindValue(6, $this->id, PDO::PARAM_INT);
        } else {
            $stmt = $conexao->prepare("INSERT INTO tb_contatos (nome, sobrenome, email, telefone, celular) VALUES (? ,?, ?, ?, ?)");
        }
        if (!is_null($this->nome)) {
            $stmt->bindValue(1, $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->sobrenome, (is_null($this->sobrenome)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(3, $this->email, (is_null($this->email)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(4, $this->telefone, (is_null($this->telefone)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(5, $this->celular, (is_null($this->celular)) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        } else {
            throw new PDOException('Erro: o atributo nome não pode ser nulo');
        }

        if ($stmt->execute()) {
            return ($stmt->rowCount() > 0)? TRUE : FALSE;;
        } else {
            //throw new PDOException(Contato::ERRO_CONEXAO);
            return FALSE;
        }
    }

    /**
     * Método para excluir contato
     * @return boolean
     */
    public function destruir(): bool
    {
        if ($this->id != NULL) {
            $conexao = Conexao::getInstancia('contatos');
            $stmt    = $conexao->prepare("DELETE FROM tb_contatos WHERE id=?");
            $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ($stmt->rowCount() > 0)? TRUE : FALSE;
            } else {
                //throw new PDOException(Contato::ERRO_CONEXAO);
                return FALSE;
            }
        } else {
            throw new Exception('Erro: operação ilegal – dados ainda não persistidos');
        }
    }

    /**
     * Método para carregar contato
     * @return boolean
     */
    public static function carregar(int $id): Contato
    {

        $conexao = Conexao::getInstancia('contatos');
        $stmt    = $conexao->prepare("SELECT * FROM tb_contatos WHERE id=?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $contato   = new self;
                $recordSet = $stmt->fetch(PDO::FETCH_OBJ);
                $contato->setId($recordSet->id);
                $contato->setNome($recordSet->nome);

                if (!is_null($recordSet->sobrenome)) $contato->setSobrenome($recordSet->sobrenome);
                if (!is_null($recordSet->email)) $contato->setEmail($recordSet->email);
                if (!is_null($recordSet->telefone)) $contato->setTelefone($recordSet->telefone);
                if (!is_null($recordSet->celular)) $contato->setCelular($recordSet->celular);

                return $contato;
            }
        } else {
            throw new PDOException(Contato::ERRO_CONEXAO);
        }
    }

    /**
     * Método para retonar os atributos como array
     * toArray
     * @return array
     */
    public function toArray(): array
    {
        return array('id' => $this->id,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'email' => $this->email,
            'telenone' => $this->telefone,
            'celular' => $this->celular);
    }

    /**
     * Método adicional para listar contatos
     * @var string $filtro Define um critério como filtro
     * @return array
     */
    public static function listar(string $filtro = ''): array
    {
        $conexao = Conexao::getInstancia('contatos');

        $sql = "SELECT * FROM tb_contatos";

        if ($filtro != '') {
            $sql .= $filtro;
        }

        $exec = $conexao->prepare($sql);

        if ($exec->execute()) {

            if ($exec->rowCount() > 0) {

                $arr = Array();

                foreach ($exec->fetchAll(PDO::FETCH_OBJ) as $recorset) {

                    $tmpContato = new self;
                    $tmpContato->setId($recorset->id);
                    $tmpContato->setNome($recorset->nome);

                    if (!is_null($recorset->sobrenome)) $tmpContato->setSobrenome($recorset->sobrenome);
                    if (!is_null($recorset->email)) $tmpContato->setEmail($recorset->email);
                    if (!is_null($recorset->telefone)) $tmpContato->setTelefone($recorset->telefone);
                    if (!is_null($recorset->celular)) $tmpContato->setCelular($recorset->celular);

                    $arr[] = $tmpContato;

                    unset($tmpContato);
                }

                return $arr;
            } else {
                return array();
            }
        } else {
            throw new PDOException(Contato::ERRO_CONEXAO);
        }
    }
}
