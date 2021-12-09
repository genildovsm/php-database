<?php

namespace GenildoMartins\BuildQuery;

use GenildoMartins\BuildQuery\DB;

class Pagination
{
	private $ipp;
	private $results;
	private $pages;
	private $currentPage;
	private $foundRows;

	public function __construct(string $table, string $where='', array $values=[], $currentPage=1, int $ipp=2)
	{		
		$this->ipp = $ipp;
		$this->currentPage = filter_var($currentPage, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) ? $currentPage : 1;

		$db = new DB($table);

		$stmt = $db->select(where:$where, values:$values, limit:$this->getLimit());
		$stmt->execute();
		$this->foundRows = $db->getFoundRows();
		$this->pages = ceil($this->foundRows/$ipp);

		if ($this->currentPage > $this->pages and $this->foundRows > 0) {
			
			$this->currentPage = $this->pages;
			$stmt = $db->select(where:$where, values:$values, limit:$this->getLimit());
			$stmt->execute();

		}		

		$this->results = $stmt->fetchAll();

	}

	private function getLimit()
	{
		return ($this->currentPage-1)*$this->ipp.','.$this->ipp;
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


}