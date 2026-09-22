<?php

require_once __DIR__ . '/../config/Database.php';

abstract class Model
{
	protected PDO $db;

	public function __construct()
	{
		$this->db = Database::getConnection();
	}

	protected function fetchAll(string $sql, array $params = []): array
	{
		$statement = $this->db->prepare($sql);
		$statement->execute($params);
		return $statement->fetchAll();
	}

	protected function fetchOne(string $sql, array $params = []): ?array
	{
		$statement = $this->db->prepare($sql);
		$statement->execute($params);
		$result = $statement->fetch();
		return $result ?: null;
	}

	protected function execute(string $sql, array $params = []): bool
	{
		$statement = $this->db->prepare($sql);
		return $statement->execute($params);
	}
}
