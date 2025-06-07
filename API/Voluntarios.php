<?php

require_once 'config.php';

class Voluntarios
{
    // Método para conectar ao banco de dados
    private static function connect()
    {
        try {
            $conn = new PDO(dbDrive . ':host=' . dbHost . ';dbname=' . dbName, dbUser, dbPass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    // Método para inserir um voluntário
    public static function insert($dados)
    {
        $tabela = "voluntarios";
        $connPdo = self::connect();

        $sql = "INSERT INTO $tabela (Nome, Data_Nascimento, CPF, Endereco, Telefone, Email, Data_Cadastro, Cargo) 
                VALUES (:Nome, :Data_Nascimento, :CPF, :Endereco, :Telefone, :Email, :Data_Cadastro, :Cargo)";

        $stmt = $connPdo->prepare($sql);

        // Mapear os parâmetros
        $stmt->bindValue(':Nome', $dados['Nome']);
        $stmt->bindValue(':Data_Nascimento', $dados['Data_Nascimento']);
        $stmt->bindValue(':CPF', $dados['CPF']);
        $stmt->bindValue(':Endereco', $dados['Endereco']);
        $stmt->bindValue(':Telefone', $dados['Telefone']);
        $stmt->bindValue(':Email', $dados['Email']);
        $stmt->bindValue(':Data_Cadastro', $dados['Data_Cadastro']);
        $stmt->bindValue(':Cargo', $dados['Cargo']);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return json_encode(["status" => "success", "message" => "Dados cadastrados com sucesso!"]);
        } else {
            return json_encode(["status" => "error", "message" => "Erro ao inserir dados."]);
        }
    }

    // Método para buscar voluntário por ID
    public static function select($id)
    {
        $tabela = "voluntarios";
        $connPdo = self::connect();

        $sql = "SELECT * FROM $tabela WHERE codigo = :id";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return json_encode(["status" => "success", "data" => $dados]);
        } else {
            return json_encode(["status" => "error", "message" => "Código não encontrado!"]);
        }
    }

    // Método para listar todos os voluntários
    public static function selectAll()
    {
        $tabela = "voluntarios";
        $connPdo = self::connect();

        $sql = "SELECT * FROM $tabela";
        $stmt = $connPdo->prepare($sql);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(["status" => "success", "data" => $dados]);
        } else {
            return json_encode(["status" => "error", "message" => "Tabela vazia!"]);
        }
    }

    // Método para atualizar os dados de um voluntário
    public static function update($id, $dados)
    {
        $tabela = "voluntarios";
        $connPdo = self::connect();

        $sql = "UPDATE $tabela SET Nome = :Nome, Data_Nascimento = :Data_Nascimento, CPF = :CPF, Endereco = :Endereco, 
                Telefone = :Telefone, Email = :Email, Data_Cadastro = :Data_Cadastro, Cargo = :Cargo 
                WHERE codigo = :id";

        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':Nome', $dados['Nome']);
        $stmt->bindValue(':Data_Nascimento', $dados['Data_Nascimento']);
        $stmt->bindValue(':CPF', $dados['CPF']);
        $stmt->bindValue(':Endereco', $dados['Endereco']);
        $stmt->bindValue(':Telefone', $dados['Telefone']);
        $stmt->bindValue(':Email', $dados['Email']);
        $stmt->bindValue(':Data_Cadastro', $dados['Data_Cadastro']);
        $stmt->bindValue(':Cargo', $dados['Cargo']);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return json_encode(["status" => "success", "message" => "Dados alterados com sucesso!"]);
        } else {
            throw new Exception("Erro ao alterar dados ou nenhum dado foi alterado.");
        }
    }

    // Método para deletar um voluntário
    public static function delete($id)
    {
        $tabela = "voluntarios";
        $connPdo = self::connect();

        $sql = "DELETE FROM $tabela WHERE codigo = :id";
        $stmt = $connPdo->prepare($sql);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return json_encode(["status" => "success", "message" => "Dados excluídos com sucesso!"]);
        } else {
            throw new Exception("Erro ao excluir ou nenhum dado encontrado.");
        }
    }
}

?>
