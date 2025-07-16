# Sistema CRUD - Pandin Dev

Sistema CRUD (Create, Read, Update, Delete) completo desenvolvido em PHP puro, seguindo os princípios da arquitetura MVC (Model-View-Controller) com design moderno e responsivo.

## 📋 Funcionalidades

- **Criar usuários**: Cadastro de novos usuários com validação completa
- **Listar usuários**: Visualização de todos os usuários cadastrados
- **Visualizar usuário**: Detalhes completos de um usuário específico
- **Editar usuários**: Atualização de informações dos usuários
- **Excluir usuários**: Remoção de usuários com confirmação
- **Import/Export XML**: Importação e exportação de dados em formato XML
- **Sistema de logs**: Registro completo de operações no banco de dados
- **Validação robusta**: Validação completa de todos os campos
- **Interface responsiva**: Layout responsivo com Bootstrap 5
- **Feedback visual**: Mensagens de sucesso e erro para todas as operações

## 🏗️ Arquitetura

```
project/
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── UserController.php
│   │   └── LogController.php
│   ├── core/
│   │   ├── Database.php
│   │   ├── Logger.php
│   │   └── Router.php
│   ├── models/
│   │   └── User.php
│   └── views/
│       ├── layouts/
│       │   ├── header.php
│       │   └── footer.php
│       ├── users/
│       │   ├── index.php
│       │   ├── create.php
│       │   ├── edit.php
│       │   └── show.php
│       ├── logs/
│       │   └── index.php
│       └── home.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── database.example.php
├── database/
│   └── schema.sql
├── storage/
│   └── logs/
│       └── database_actions.json
└── public/
    ├── assets/
    │   └── css/
    │       └── style.css
    ├── .htaccess
    └── index.php
```

## 🚀 Instalação

### Pré-requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Apache com mod_rewrite habilitado
- Extensões PHP: PDO, PDO_MySQL

### Passos para instalação

1. **Clone ou baixe o projeto**
   ```bash
   git clone https://github.com/pandin-dev/php-crud
   cd php-crud
   ```

2. **Configure o servidor web**
   - Configure o Apache para apontar para a pasta `public/`
   - Certifique-se de que o mod_rewrite está habilitado

3. **Configure o banco de dados**
   
   **Passo 1: Criar o banco de dados**
   ```sql
   CREATE DATABASE meu_sistema_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   *(Use o nome que preferir para o banco)*
   
   **Passo 2: Configurar as credenciais**
   - Copie o arquivo `config/database.example.php` para `config/database.php`
   - Edite com suas credenciais:
   ```php
   return [
       'host' => 'localhost',
       'dbname' => 'meu_sistema_crud', // Nome do seu banco
       'username' => 'seu_usuario',
       'password' => 'sua_senha',
       // ...
   ];
   ```

4. **Execute o script SQL**
   ```sql
   -- Conecte ao seu banco e execute:
   mysql -u seu_usuario -p meu_sistema_crud < database/schema.sql
   ```
   *Ou importe o arquivo `database/schema.sql` via phpMyAdmin*

5. **Configure as permissões**
   ```bash
   chmod 755 public/
   chmod 644 public/.htaccess
   ```

## 💡 Configuração Rápida

### Para desenvolvimento local (XAMPP/WAMP):

1. **Extraia o projeto** na pasta `htdocs/`
2. **Crie um banco** via phpMyAdmin (ex: `meu_crud`)
3. **Importe** o arquivo `database/schema.sql`
4. **Copie** `config/database.example.php` → `config/database.php`
5. **Configure** as credenciais no arquivo copiado
6. **Acesse** `http://localhost/php-crud/public/`

## 🔧 Configuração do Apache

### VirtualHost recomendado:

```apache
<VirtualHost *:80>
    ServerName crud-local.com
    DocumentRoot "/caminho/para/projeto/public"
    
    <Directory "/caminho/para/projeto/public">
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog logs/crud_error.log
    CustomLog logs/crud_access.log common
</VirtualHost>
```

### Ou usando XAMPP/WAMP:

1. Coloque o projeto na pasta `htdocs/`
2. Acesse `http://localhost/public/`

## 🗄️ Estrutura do Banco de Dados

### Tabela `users`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT(11) AUTO_INCREMENT | Chave primária |
| nome | VARCHAR(255) NOT NULL | Nome completo do usuário |
| email | VARCHAR(255) NOT NULL UNIQUE | Email único do usuário |
| telefone | VARCHAR(20) NOT NULL | Telefone do usuário |
| data_nascimento | DATE NOT NULL | Data de nascimento |
| created_at | TIMESTAMP | Data de criação |
| updated_at | TIMESTAMP | Data da última atualização |

## 🌐 Rotas do Sistema

| Método | Rota | Ação | Descrição |
|--------|------|------|-----------|
| GET | `/` | HomeController@index | Página inicial |
| GET | `/users` | UserController@index | Listar usuários |
| GET | `/users/create` | UserController@create | Formulário de criação |
| POST | `/users/store` | UserController@store | Salvar novo usuário |
| GET | `/users/show?id={id}` | UserController@show | Visualizar usuário |
| GET | `/users/edit?id={id}` | UserController@edit | Formulário de edição |
| POST | `/users/update` | UserController@update | Atualizar usuário |
| POST | `/users/delete` | UserController@delete | Excluir usuário |
| GET | `/logs` | LogController@index | Página de logs |
| GET | `/logs/clear` | LogController@clear | Limpar logs |
| GET | `/logs/api` | LogController@api | API JSON dos logs |
| GET | `/xml` | XmlController@index | Gerenciar XML |
| POST | `/xml/import` | XmlController@import | Importar XML |
| GET | `/xml/export` | XmlController@export | Exportar XML |
| GET | `/xml/exemplo` | XmlController@exemplo | Baixar XML exemplo |

## ✅ Validações Implementadas

- **Nome**: Obrigatório, mínimo 2 caracteres
- **Email**: Obrigatório, formato válido, único no banco
- **Telefone**: Obrigatório, mínimo 10 dígitos
- **Data de Nascimento**: Obrigatória, formato válido

## 🛡️ Segurança

- **Prepared Statements**: Prevenção total contra SQL Injection
- **Sanitização de dados**: Todos os dados são sanitizados antes da exibição
- **Headers de segurança**: Configurados no .htaccess
- **Tratamento de erros**: Sistema completo de logs de erro

## 🎨 Interface e UX

- **Bootstrap 5**: Framework CSS para design responsivo moderno
- **Font Awesome 6**: Ícones vetoriais para melhor experiência
- **Animações CSS**: Efeitos hover e transições suaves
- **Cards interativos**: Elementos visuais com feedback tátil
- **Máscaras de entrada**: JavaScript para formatação automática
- **Confirmações inteligentes**: Diálogos de confirmação para ações críticas
- **Feedback visual**: Sistema completo de alertas e notificações

## 🔧 Funcionalidades Técnicas

- **Arquitetura MVC**: Separação clara de responsabilidades
- **Singleton Pattern**: Para conexão otimizada com banco de dados
- **Roteamento personalizado**: Sistema de rotas próprio e eficiente
- **Sistema de logs**: Registro completo de operações do banco
- **Tratamento de exceções**: Try/catch em todas as operações críticas
- **Logs de erro**: Registro detalhado de erros em arquivos
- **Código limpo**: Documentação completa e comentários explicativos
- **Prepared Statements**: Segurança máxima contra SQL Injection
- **Validação dupla**: Client-side e server-side validation

## 📱 Responsividade

O sistema é totalmente responsivo e funciona em:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (até 767px)

## 🧪 Testando o Sistema

1. Acesse a página inicial
2. Clique em "Gerenciar Usuários"
3. Teste todas as operações CRUD:
   - Criar um novo usuário
   - Visualizar a lista
   - Editar um usuário existente
   - Visualizar detalhes
   - Excluir um usuário

## 📝 Logs e Debug

- Logs de erro são salvos automaticamente
- Para debug, ative a exibição de erros no `index.php`
- Verifique o console do navegador para erros JavaScript

## 📞 Contato e Suporte

### 👨‍💻 Desenvolvedor: Pandin Dev

- **Email**: [pandin@pandin.dev](mailto:pandin@pandin.dev)
- **Website**: [pandin.dev](https://pandin.dev)
- **WhatsApp**: [+55 11 96384-0038](https://wa.me/5511963840038)
- **Telegram**: [@pandin](https://t.me/pandin)
- **Telefone**: +55 11 96384-0038

### 🛠️ Suporte Técnico

Para dúvidas ou problemas técnicos:

1. **Verifique os logs** de erro no sistema
2. **Confirme a configuração** do banco de dados
3. **Teste as permissões** de arquivo e diretório
4. **Verifique se o mod_rewrite** está habilitado no Apache
5. **Entre em contato** pelos canais acima para suporte personalizado

### 💼 Serviços Disponíveis

- Desenvolvimento de sistemas web personalizados
- Consultoria em PHP e arquitetura de software
- Otimização de performance e segurança
- Manutenção e evolução de sistemas existentes
- Treinamentos e workshops

---

**© 2025 Sistema CRUD - Desenvolvido por [Pandin Dev](https://pandin.dev)**

*Especialista em desenvolvimento web moderno, criando soluções eficientes e escaláveis.*
