<?php
class DbConnect
{
	private $server = 'eu-cdbr-west-03.cleardb.net';
	private $dbname = 'heroku_de2ad61d358789e';
	private $user = 'bfed4e75249dde';
	private $pass = '9b43b917';

	public function connect()
	{
		try {
			$conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->pass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (\Exception $e) {
			echo "Database Error: " . $e->getMessage();
		}
	}
	public function createTable()
	{
		try {
			$conn = $this->connect();
			$sql = "
                CREATE TABLE IF NOT EXISTS `products` (
                    `id` int(11) NOT NULL,
                    `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `price` decimal(10,2) NOT NULL,
                    `attribute` enum('Weight','Dimensions','Size') COLLATE utf8mb4_unicode_ci NOT NULL,
                    `attribute_value` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `sku` (`sku`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
			$conn->exec($sql);
		} catch (\Exception $e) {
			echo "Table Creation Error: " . $e->getMessage();
		}
	}

}
?>