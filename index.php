<?php

putenv('DB_HOST=127.0.0.1');
putenv('DB_NAME=db01');
putenv('DB_PORT=3306');
putenv('DB_USER=lab');
putenv('DB_PASS=12345678');
putenv('DEBUG=true');

function dd($var, $die=false)
{
	echo '<pre style="padding:1rem;font-family:consolas;font-size:.8rem;background-color:#eee;">';
	print_r($var);
	echo '</pre>';

	if ($die) exit;
}

require __DIR__.'/vendor/autoload.php';

use GenildoMartins\BuildQuery\DB;
use GenildoMartins\BuildQuery\Pagination;



// $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
// $titulo = trim(filter_input(INPUT_GET, 'titulo', FILTER_SANITIZE_STRING));

// $condicoes = [
// 	is_int($id) ? 'id='.$id : null,
// 	strlen($titulo) ? 'titulo like "%'.str_replace(' ','%',$titulo).'%"' : null
// ];


$where = 'id<?';
$values = [15]; // Valores que serão aplicados no bind "?"

$pagination = new Pagination (
	table:'vagas', 
	where: $where, 
	values: $values,
	currentPage: $_GET['page'] ?? null
);


echo '<h2>Select com paginação</h2>';

echo 'Resultset:';
dd($pagination->getResults());

echo '<br>CurrentPage: '.$pagination->getCurrentPage();
echo '<br>Pages: '.$pagination->getPages();
echo '<br>FoundRows: '.$pagination->getFoundRows();


/**
 * Select convencional
 */

$stmt = (new DB(table:'vagas'))->select(
	fields:'id, titulo',
	where: $where,
	values: $values
);

echo '<h2>Select convencional</h2>';
dd($stmt->fetchAll());
