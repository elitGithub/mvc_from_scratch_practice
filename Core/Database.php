<?php


namespace App\Core;


use PDO;
use App\Migrations;

/**
 * Class Database
 * @package App\Core
 */
class Database
{

	public PDO $pdo;

	private $skipMigrations = ['.', '..'];

	public function __construct(array $config)
	{
		$dsn = $config['dsn'] ?? '';
		$user = $config['user'] ?? '';
		$password = $config['password'] ?? '';
		$this->pdo = new PDO($dsn, $user, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function applyMigrations()
	{
		$this->createMigrationsTable();
		$appliedMigrations = $this->getAppliedMigrations();

		$files = scandir(Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'migrations');

		$toApplyMigrations = array_diff($files, $appliedMigrations);
		foreach ($toApplyMigrations as $migration) {
			if (in_array($migration, $this->skipMigrations)) {
				continue;
			}

			require_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$this->addNameSpace($className);
			$instance = new $className();

			echo "Migrating $migration" . PHP_EOL;
			$instance->up();
			echo "Migrated $migration" . PHP_EOL;
			$newMigrations[] = $migration;
		}

		if (!empty($newMigrations)) {
			$this->saveMigrations($newMigrations);
		} else {
			echo "No new migrations to apply";
		}
	}

	public function createMigrationsTable()
	{
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    			id INT AUTO_INCREMENT PRIMARY KEY,
    			migration VARCHAR(255),
    			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
    			ENGINE=INNODB");
	}

	public function getAppliedMigrations(): array
	{
		$statement = $this->pdo->prepare("SELECT migration FROM migrations;");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}

	protected function addNameSpace(array|string &$className)
	{
		if (is_string($className)) {
			$className = "\\App\Migrations\\$className";
		}
	}

	public function saveMigrations(array $migrations)
	{
		$this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
                                          ('')");
	}
}