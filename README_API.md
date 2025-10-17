# 🧠 TODO List API — CodeIgniter 3.1

API RESTful desenvolvida em **PHP / CodeIgniter 3.1**, para gerenciamento de tarefas (TODOs).  
Permite criar, listar, atualizar e excluir tarefas de forma simples e intuitiva.

---

## 🔗 Base URL
http://localhost:8080/api/todos

> Durante o desenvolvimento local via Docker, o servidor roda em `localhost:8080`.

---

## 📦 Estrutura do Projeto

---

## 📦 Estrutura do Projeto
application/
├── controllers/
│ └── api/
│ └── Todos.php
├── models/
│ └── Todo_model.php
├── config/
│ └── routes.php
└── index.php ← frontend simples com Bootstrap + busca


---

## ⚙️ Endpoints

### ➕ Criar uma tarefa

`POST /api/todos`

#### Corpo da Requisição (JSON)

```json
{
  "title": "Estudar CodeIgniter",
  "description": "Ler a documentação e testar exemplos"
}
{
  "data": {
    "id": 3,
    "title": "Estudar CodeIgniter",
    "description": "Ler a documentação e testar exemplos",
    "status": "pending",
    "created_at": "2025-10-16 22:45:12",
    "updated_at": null
  }
}

📋 Listar todas as tarefas

GET /api/todos

Resposta (200)

{
  "data": [
    {
      "id": 1,
      "title": "Montar Docker",
      "description": "Subir app e banco",
      "status": "pending",
      "created_at": "2025-10-16 22:06:39",
      "updated_at": null
    },
    {
      "id": 2,
      "title": "Estudar CI3",
      "description": "Ler a documentação e exemplos",
      "status": "done",
      "created_at": "2025-10-16 22:06:39",
      "updated_at": "2025-10-16 22:20:12"
    }
  ]
}

🔍 Exibir uma tarefa específica

GET /api/todos/{id}

Exemplo
GET /api/todos/1
Resposta (200)
{
  "data": {
    "id": 1,
    "title": "Montar Docker",
    "description": "Subir app e banco",
    "status": "pending",
    "created_at": "2025-10-16 22:06:39",
    "updated_at": null
  }
}

Resposta (404)
{
  "error": "Not found"
}

✏️ Atualizar tarefa

PUT /api/todos/{id}

Corpo da Requisição (JSON)

{
  "title": "Estudar CI3",
  "description": "Rever rotas e models",
  "status": "done"
}

Resposta (200)
{
  "data": {
    "id": 2,
    "title": "Estudar CI3",
    "description": "Rever rotas e models",
    "status": "done",
    "created_at": "2025-10-16 22:06:39",
    "updated_at": "2025-10-16 23:11:02"
  }
}


🗑️ Excluir tarefa

DELETE /api/todos/{id}

Exemplo
DELETE /api/todos/2

Resposta (200)
{
  "deleted": true
}

Resposta (404)
{
  "error": "Not found"
}

🧩 Estrutura da Tabela (MySQL)
CREATE TABLE todos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  status ENUM('pending','done') DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL
);


💡 Observações
Todos os retornos são no formato JSON.

Erros sempre retornam um campo "error" com mensagem e código HTTP adequado.

O campo "status" aceita apenas pending ou done.

O frontend (public/index.html) consome essa API via fetch().

🚀 Execução via Docker

1. Subir os containers:
docker-compose up -d --build

2.Acessar o app:

API → http://localhost:8080/api/todos

Frontend → http://localhost:8080/public/

3.Encerrar:
docker-compose down

🧑‍💻 Autor

Zaira Amorim
Desenvolvedora PHP Full Stack

contato: (amorim.zaira@gmail.com)
