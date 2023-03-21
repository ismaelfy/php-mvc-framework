<?php

// app/Packages/DB/DB.php

namespace App\Packages;

use PDO;
use PDOException;

class DB
{
    private $connection;

    public function __construct() {
        $db_config = include_once(__DIR__ . '/../../config/database.php');
        $db_driver = $db_config['driver'];
        $db_host = $db_config['host'];
        $db_port = $db_config['port'];
        $db_name = $db_config['database'];
        $db_user = $db_config['username'];
        $db_password = $db_config['password'];

        try {
            $this->connection = new \PDO("$db_driver:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function select($table, $columns = ['*'])
    {
        $columns = implode(',', $columns);
        $sql = "SELECT $columns FROM $table";
        return $this->query($sql)->fetchAll();
    }

    public function find($table, $id, $columns = ['*'])
    {
        $columns = implode(',', $columns);
        $sql = "SELECT $columns FROM $table WHERE id = ?";
        return $this->query($sql, [$id])->fetch();
    }

    public function insert($table, $data)
    {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $params = array_values($data);

        $this->query($sql, $params);
        return $this->connection->lastInsertId();
    }

    public function update($table, $id, $data)
    {
        $set = implode('=?, ', array_keys($data)) . '=?';
        $params = array_values($data);
        array_push($params, $id);

        $sql = "UPDATE $table SET $set WHERE id = ?";
        return $this->query($sql, $params)->rowCount();
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        return $this->query($sql, [$id])->rowCount();
    }
}
