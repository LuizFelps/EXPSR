<?php 

/**
* Classe responsável por gerir a conexão com a base de dados.
* Aplica o design pattern Singleton para não sobrecarregar de conexões.
*/
final class Banco {

    /**
    * @var PDO armazena a conexão e retorna quando solicitado
    */
    private static $conexao;

    private function __construct() {}

    /**
    *  Função (estática) na qual usuários podem obter a conxão. 
    *  Somente uma será criada.
    *
    *  @return PDO conexão com o banco
    */
    public static function getInstance() {
        if (is_null(self::$conexao)) {
            self::$conexao = new PDO('sqlite:login.sqlite3');
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexao;
    }

    //Cria a tabela
    public static function createSchema() {
        $db = self::getInstance();
        $db->exec('
            CREATE TABLE IF NOT EXISTS Usuarios (
                email TEXT TEXT PRIMARY KEY,
                senha TEXT,
                nome TEXT
            )
        ');

        $db->exec('            
            CREATE TABLE IF NOT EXISTS Albuns (
            email_user TEXT,
            nomeAlbum TEXT, 
            visibilidade TEXT,
            FOREIGN KEY(email_user) REFERENCES Usuarios(email)
        )');

        $db->exec('            
            CREATE TABLE IF NOT EXISTS Imagens (
            email_user TEXT,
            nomeAlbum TEXT,
            caminho TEXT, 
            descricao TEXT,
            FOREIGN KEY(email_user) REFERENCES Usuarios(email),
            FOREIGN KEY(nomeAlbum) REFERENCES Albuns(nomeAlbuns)
        )');        


    }
}

?>