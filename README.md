## How to use

### Arquivo index.php
```php

/**
 * 
 * Configurar os parâmetros do banco nas seguintes variáveis de ambiente 
 * 
 * */
putenv('DB_HOST=servidor');
putenv('DB_NAME=banco');
putenv('DB_PORT=3306'); // Porta utilizada pelo banco de dados. Ex: Mysql
putenv('DB_USER=usuario');
putenv('DB_PASS=senha');
putenv('DEBUG=true'); // Ativar as mensagens de possíveis erros


require __DIR__.'/vendor/autoload.php';

use GenildoMartins\BuildQuery\DB;
use GenildoMartins\BuildQuery\Pagination;



```