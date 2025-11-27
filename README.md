# 💧 AquaDenuncia: Denúncia Rápida de Desperdício (Hackathon)

## 🎯 Objetivo do Projeto
Esta aplicação visa fornecer uma ferramenta simples e rápida para cidadãos **reportarem desperdício de recursos urbanos** (como vazamentos de água, luzes públicas acesas durante o dia ou descarte irregular de lixo) diretamente no local do incidente, utilizando a localização GPS do dispositivo. O projeto demonstra um sistema completo de ponta a ponta (Front-end e Back-end) para persistência de dados.

## 🛠️ Tecnologias Utilizadas
* **Backend:** PHP (Lógica do Servidor e manipulação de dados).
* **Banco de Dados:** MySQL/MariaDB (Para o CRUD).
* **Frontend:** HTML, CSS (Bootstrap 5) e JavaScript (para captura de GPS).

## 📊 Implementação do CRUD
O projeto demonstra todas as operações básicas do CRUD (Create, Read, Update):

| Operação | Arquivo Principal | Descrição |
| :--- | :--- | :--- |
| **CREATE** | `login.html` -> `salvar_denuncia.php` | O formulário recebe os dados e os insere na tabela `denuncias`. |
| **READ** | `lista_denuncias.php` | Lista todas as denúncias com `status = 'Aberto'`. |
| **UPDATE** | `lista_denuncias.php` | O botão "Resolver" atualiza o `status` de 'Aberto' para 'Resolvido'. |

---

## 🚀 Como Rodar o Projeto Localmente

Para testar a aplicação, é necessário ter um servidor local (XAMPP, WAMP, ou MAMP) rodando.

### 1. Configuração do Banco de Dados
Acesse o phpMyAdmin (ou ferramenta equivalente) e execute o script SQL abaixo para criar o banco de dados e a tabela necessária:

```sql
CREATE DATABASE IF NOT EXISTS hackathon_desperdicio;

USE hackathon_desperdicio;

CREATE TABLE denuncias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_desperdicio VARCHAR(255) NOT NULL,
    detalhes TEXT,
    latitude VARCHAR(50) NOT NULL,
    longitude VARCHAR(50) NOT NULL,
    status VARCHAR(50) DEFAULT 'Aberto',
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP
);