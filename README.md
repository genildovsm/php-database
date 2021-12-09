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

$pagination = new Pagination (
	table:'tabela', 
	where: $where, 
	values: $values,
	currentPage: $_GET['page'] ?? null
);


echo '<h2>Select com paginação</h2>';

echo '<pre>';
print_r($pagination->getResults());
echo '</pre>';

echo '<br>CurrentPage: '.$pagination->getCurrentPage();
echo '<br>Pages: '.$pagination->getPages();
echo '<br>FoundRows: '.$pagination->getFoundRows();


/**
 * Select convencional
 * Possibilidade de aplicar JOINS na Classe "DB".
 */

$stmt = (new DB(table:'tabela'))->select(
	fields:'campo_a, campo_b',
	where: $where,
	values: $values
);

echo '<h2>Select convencional</h2>';
echo '<pre>';
print_r($stmt->fetchAll());
echo '</pre>';
```