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
}
?>