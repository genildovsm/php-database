## How to use

### Arquivo index.php
```php

/**
 * Configurar os parâmetros do banco nas seguintes variáveis de ambiente 
 * */
putenv('DB_HOST=servidor');
putenv('DB_NAME=banco');
// Porta utilizada pelo banco de dados. Ex: Mysql
putenv('DB_PORT=3306');
putenv('DB_USER=usuario');
putenv('DB_PASS=senha');
// Ativar as mensagens de possíveis erros
putenv('DEBUG=true');


require __DIR__.'/vendor/autoload.php';

use GenildoMartins\BuildQuery\DB;
use GenildoMartins\BuildQuery\Pagination;



```