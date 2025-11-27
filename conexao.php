<?php
/**
 * ARQUIVO: conexao.php
 * Define os parâmetros e estabelece a conexão com o banco de dados MySQL.
 */

// 1. Definição das variáveis de conexão (Ambiente Local - XAMPP/WAMP)
$host = "localhost";
$usuario = "root"; // Usuário padrão do XAMPP/WAMP
$senha = "";       // Senha padrão do XAMPP/WAMP (deve ser vazio)
$database = "hackathon_desperdicio"; // Nome do seu banco de dados

// 2. Estabelece a conexão usando as variáveis definidas
$conn = new mysqli($host, $usuario, $senha, $database);

// 3. Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// 4. Define o charset para evitar problemas com acentuação
$conn->set_charset("utf8");

// IMPORTANTE: Não inclua a tag de fechamento (?>) para evitar problemas de header