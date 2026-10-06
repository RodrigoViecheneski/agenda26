<?php
// Fábrica de conexões (connection factory)
class Conexao
{
    private $usuario;
    private $senha;
    private $banco;
    private $servidor;

    private static $pdo;

    public function __construct()
    {
        $this->servidor = "db";
        $this->banco = "agenda26";
        $this->usuario = "root";
        $this->senha = "root_password";
    }
    public function conectar()
    {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO("mysql:host=" . $this->servidor . ";dbname=" . $this->banco . ";charset=utf8", $this->usuario, $this->senha);
            }
            //echo "<p class='sucesso'>✔ Conexão com o MySQL realizada com sucesso!</p>";
            return self::$pdo;
        } catch (PDOException $ex) {
            //echo "<p class='erro'>❌ Falha na conexão com o Banco de Dados: " . $ex->getMessage() . "</p>";
        }
    }
}
