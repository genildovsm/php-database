<?php

namespace GenildoMartins\BuildQuery;

use GenildoMartins\BuildQuery\DB;

class Pagination
{
	private $results;
	private $pages;
	private $currentPage;
	private $foundRows;

	public function __construct(string $table, string $where='', array $values=[], $currentPage=1, int $ipp=2)
	{		
		
		$this->currentPage = filter_var($currentPage, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) ? $currentPage : 1;

		$db = new DB($table);

		$limit = ($this->currentPage-1)*$ipp.','.$ipp;
		$stmt = $db->select(where:$where, values:$values, limit:$limit);

		$stmt->execute();

		$this->foundRows = $db->getFoundRows();
		$this->pages = ceil($this->foundRows/$ipp);

		if ($this->currentPage > $this->pages and $this->foundRows > 0) {
			
			$this->currentPage = $this->pages;

			$limit = ($this->currentPage-1)*$ipp.','.$ipp;

			$stmt = $db->select(where:$where, values:$values, limit:$limit);
			$stmt->execute();

		}		

		$this->results = $stmt->fetchAll();

	}


	public function getResults()
	{
		return $this->results;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function getPages()
	{
		return $this->pages;
	}

	public function getFoundRows()
	{
		return $this->foundRows;
	}

	// public function __construct(int $results, int $currentPage=1, int $limit=10)
	// {
	// 	$this->results = $results;
	// 	$this->limit = $limit;
	// 	$this->currentPage = filter_var($currentPage, FILTER_VALIDATE_INT,['options'=>['min_range'=>1]]) ? $currentPage : 1;
	// }

	// private function calculate()
	// {
	// 	$this->pages = ($this->results > 0) ? ceil($this->results/$this->limit) : 1;
	// 	$this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
	// }
}