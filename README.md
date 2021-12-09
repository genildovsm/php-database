## How to use

### Arquivo index.php
```php

/**
 * 
 * Configurar os parâmetros do banco nas seguintes variáveis de ambiente 
 * Ou adicioná-las ao arquivo ".env"
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




$where = 'id<?'; // Preparando a consulta
$values = [15]; // Valores que serão aplicados no bind "?"

$obPagination = new Pagination (
	table:'vagas', 
	where: $where, 
	values: $values,
	currentPage: $_GET['page'] ?? null
);


echo '<h2>Select com paginação</h2>';

echo 'Resultset:';
print_r($obPagination->getResults());

echo '<br>CurrentPage: '.$obPagination->getCurrentPage();
echo '<br>Pages: '.$obPagination->getPages();
echo '<br>FoundRows: '.$obPagination->getFoundRows();


/**
 * Select convencional
 */

$stmt = (new DB(table:'vagas'))->select(
	fields:'id, titulo',
	where: $where,
	values: $values
);

echo '<h2>Select convencional</h2>';
print_r($stmt->fetchAll());
```