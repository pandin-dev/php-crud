# Sistema de Logs de Banco de Dados

Este sistema registra automaticamente todas as ações realizadas no banco de dados, mantendo apenas as **duas últimas alterações** conforme solicitado.

## Estrutura do Sistema

### Arquivos Criados

1. **`logs/`** - Pasta onde são armazenados os arquivos de log
2. **`app/core/Logger.php`** - Classe responsável pelo gerenciamento dos logs
3. **`app/controllers/LogController.php`** - Controller para visualização e gestão dos logs
4. **`app/views/logs/index.php`** - Interface web para visualizar os logs
5. **`public/test-logs.php`** - Arquivo de teste para gerar logs de exemplo

### Funcionalidades

- ✅ **Registro automático** de todas as operações SQL (SELECT, INSERT, UPDATE, DELETE, etc.)
- ✅ **Rotação automática** mantendo apenas as 2 últimas alterações
- ✅ **Interface web** bonita e responsiva para visualizar os logs
- ✅ **API JSON** para acesso programático aos logs
- ✅ **Informações detalhadas** de cada operação:
  - Timestamp da ação
  - Tipo de operação SQL
  - Query executada
  - Parâmetros utilizados
  - Resultado da operação
  - IP do usuário
  - User Agent
  - ID único da operação

## Como Usar

### 1. Acessar os Logs pela Interface Web
```
http://localhost/logs
```

### 2. Acessar os Logs via API JSON
```
http://localhost/logs/api
```

### 3. Limpar todos os Logs
```
http://localhost/logs/clear
```

### 4. Testar o Sistema
```
http://localhost/test-logs.php
```

## Integração Automática

O sistema foi integrado automaticamente na classe `Database.php`. Todas as operações realizadas através dos métodos:
- `execute()` - Para INSERT, UPDATE, DELETE
- `fetchAll()` - Para SELECT que retorna múltiplos registros
- `fetch()` - Para SELECT que retorna um único registro

São automaticamente registradas no sistema de logs.

## Formato do Log

Cada entrada de log contém:

```json
{
    "id": "unique_id_here",
    "timestamp": "2025-07-15 14:30:25",
    "action": "INSERT",
    "sql": "INSERT INTO users (name, email) VALUES (?, ?)",
    "parameters": ["João Silva", "joao@email.com"],
    "result": "success",
    "ip_address": "127.0.0.1",
    "user_agent": "Mozilla/5.0..."
}
```

## Arquivo de Log

Os logs são armazenados em:
```
logs/database_actions.json
```

## Configuração

O sistema está configurado para manter apenas **2 logs** por vez. Para alterar este número, modifique a propriedade `$maxLogs` na classe `Logger.php`:

```php
private $maxLogs = 2; // Altere aqui para o número desejado
```

## Segurança

- Os logs incluem informações de IP e User Agent para auditoria
- As senhas e dados sensíveis nos parâmetros são registrados (considere filtrar se necessário)
- O arquivo de log tem permissões restritas do sistema de arquivos

## Demonstração

1. Acesse `http://localhost/test-logs.php` para gerar 5 operações de teste
2. Acesse `http://localhost/logs` para ver que apenas as 2 últimas foram mantidas
3. Execute mais operações e observe a rotação automática dos logs
