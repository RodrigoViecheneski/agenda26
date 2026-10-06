<?php
require 'conexao.class.php';
class Contatos
{
    private $id;
    private $nome;
    private $telefone;
    private $email;
    private $endereco;
    private $informacoes;
    private $grupo;
    private $dt_nasc;
    private $profissao;
    private $foto;
    private $status;
    //$id,$nome,$telefone,$email,$endereco,$informacoes,$grupo,$dt_nasc,$profissao,$foto,$status
    private $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    private function existeEmail($email)
    {
        $sql = $this->con->conectar()->prepare("SELECT id FROM contatos WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(); // retorna o email encontrado
        } else {
            $array = array();
        }
        return $array;
    }
    public function adicionar($email, $nome, $telefone, $endereco, $informacoes, $grupo, $dt_nasc, $profissao, $status)
    {
        $emailExistente = $this->existeEmail($email);
        if (count($emailExistente) == 0) {
            try {
                $this->nome = $nome;
                $this->telefone = $telefone;
                $this->email = $email;
                $this->endereco = $endereco;
                $this->informacoes = $informacoes;
                $this->grupo = $grupo;
                $this->dt_nasc = $dt_nasc;
                $this->profissao = $profissao;
                //$this->foto = $foto;
                $this->status = $status;
                $sql = $this->con->conectar()->prepare("INSERT INTO contatos(nome, telefone, email, endereco, informacoes, grupo, dt_nasc, profissao, status)VALUES( :nome, :telefone, :email, :endereco, :informacoes, :grupo, :dt_nasc, :profissao, :status)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
                $sql->bindParam(":email", $this->email, PDO::PARAM_STR);
                $sql->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
                $sql->bindParam(":informacoes", $this->informacoes, PDO::PARAM_STR);
                $sql->bindParam(":grupo", $this->grupo, PDO::PARAM_STR);
                $sql->bindParam(":dt_nasc", $this->dt_nasc, PDO::PARAM_STR);
                $sql->bindParam(":profissao", $this->profissao, PDO::PARAM_STR);
                //$sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
                $sql->bindParam(":status", $this->status, PDO::PARAM_STR);
                $sql->execute();
                return TRUE;
            } catch (PDOException $ex) {
                return 'ERRO: ' . $ex->getMessage();
            }
        } else {
            return FALSE;
        }
    }
    public function listar()
    {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos");
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();
        }
    }
    public function getFoto()
    {
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT *,
        (select foto_contato.url from foto_contato where foto_contato.id_contato = contatos.id limit 1)as url From contatos");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }
    public function deletar($id)
    {
        $sql = $this->con->conectar()->prepare("DELETE FROM contatos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
    public function buscar($id)
    {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return $sql->fetch();
            } else {
                return array();
            }
        } catch (PDOException $ex) {
            echo "ERRO: " . $ex->getMessage();
        }
    }
    public function editar($nome, $telefone, $email, $endereco, $informacoes, $grupo, $dt_nasc, $profissao, $foto, $status, $id)
    {
        $emailExistente = $this->existeEmail($email);
        if (count($emailExistente) > 0 && $emailExistente['id'] != $id) {
            return FALSE;
        } else {
            try {
                $sql = $this->con->conectar()->prepare("UPDATE contatos SET nome = :nome, telefone = :telefone,  email = :email, endereco = :endereco, informacoes = :informacoes, grupo = :grupo, dt_nasc = :dt_nasc, profissao = :profissao, status = :status WHERE id = :id ");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':telefone', $telefone);
                $sql->bindValue(':email', $email);
                $sql->bindValue(':endereco', $endereco);
                $sql->bindValue(':informacoes', $informacoes);
                $sql->bindValue(':grupo', $grupo);
                $sql->bindValue(':dt_nasc', $dt_nasc);
                $sql->bindValue(':profissao', $profissao);
                $sql->bindValue(':status', $status);
                $sql->bindValue(':id', $id);
                $sql->execute();
                //inserir imagem se houver
                if (count($foto) > 0) {
                    for ($q = 0; $q < count($foto['tmp_name']); $q++) {
                        $tipo = $foto['type'][$q];
                        if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                            $tmpname = md5(time() . rand(0, 9999)) . '.jpg';
                            move_uploaded_file($foto['tmp_name'][$q], 'img/contatos/' . $tmpname);
                            list($width_orig, $height_orig) = getimagesize('img/contatos/' . $tmpname);
                            $ratio = $width_orig / $height_orig;

                            $width = 500;
                            $height = 500;
                            if ($width / $height > $ratio) {
                                $width = (int)round($height * $ratio);
                            } else {
                                $height = (int) round($width / $ratio);
                            }
                            // Criar imagem original
                            if ($tipo === 'image/jpeg') {

                                $origi = imagecreatefromjpeg(
                                    'img/contatos/' . $tmpname
                                );
                            } elseif ($tipo === 'image/png') {

                                $origi = imagecreatefrompng(
                                    'img/contatos/' . $tmpname
                                );
                            } else {
                                continue;
                            }
                            $img = imagecreatetruecolor($width, $height);
                            if ($tipo === 'image/jpeg') {
                                $origi = imagecreatefromjpeg('img/contatos/' . $tmpname);
                            } elseif ($tipo === 'image/png') {
                                $origi = imagecreatefrompng('img/contatos/' . $tmpname);
                            }
                            imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                            //Salvar imagem servidor
                            imagejpeg($img, 'img/contatos/' . $tmpname, 80);
                            //Salvar a url da foto no bd
                            $sql = $this->con->conectar()->prepare("INSERT INTO foto_contato SET id_contato = :id_contato, url = :url");
                            $sql->bindValue("id_contato", $id);
                            $sql->bindValue(":url", $tmpname);
                            $sql->execute();
                        }
                    }
                }
            } catch (PDOException $ex) {
                echo 'ERRO: ' . $ex->getMessage();
            }
        }
    }
    public function getContato($id)
    {
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
            //mostrar todas as imagens cadastradas para o contato
            $array['foto'] = array();
            $sql = $this->con->conectar()->prepare("SELECT id, url FROM foto_contato WHERE id_contato = :id_contato");
            $sql->bindValue(":id_contato", $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $array['foto'] = $sql->fetchAll();
            }
        }
        return $array;
    }
}
