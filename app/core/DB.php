<?php

namespace App\Core;

use PDO;
use PDOException;

class DB
{
    protected static $pdo;
    protected static $table;
    protected static $where = '';
    protected static $params = [];
    private static $instance = null;

    private static function connect()
    {
        try {
            if (self::$pdo == null) {
                $config = require_once __DIR__ . '/../../config/database.php';
                $connection = $config['connections'][$config['default']];

                // Conectar a la base de datos
                self::$pdo = new PDO(
                    "{$connection['driver']}:host={$connection['host']};port={$connection['port']};dbname={$connection['database']}",
                    $connection['username'],
                    $connection['password']
                );
            }
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::connect();
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function table($table)
    {
        self::$table = $table;
        return new static;
    }

    public static function select($columns = ['*'])
    {
        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
        $sql = "SELECT $columns FROM " . self::$table . self::$where;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(self::$params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function query($sql, $params = [])
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function first()
    {
        $result = self::select('*');
        return isset($result[0]) ? $result[0] : null;
    }

    public static function find($id)
    {
        $result = self::query("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll()
    {
        return self::select('*');
    }

    public static function findOne($column, $value)
    {
        $result = self::query("SELECT * FROM " . self::$table . " WHERE $column = ?", [$value]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $keys = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO " . self::$table . " ($keys) VALUES ($values)";
        self::query($sql, array_values($data));
        return self::$pdo->lastInsertId();
    }

    public static function update($data)
    {
        $set = implode('=?, ', array_keys($data)) . '=?';
        $sql = "UPDATE " . self::$table . " SET " . $set . self::$where;
        return self::query($sql, array_merge(array_values($data), self::$params))->rowCount();
    }

    public static function delete()
    {
        $sql = "DELETE FROM " . self::$table . self::$where;
        return self::query($sql, self::$params)->rowCount();
    }

    public static function where($condition, $params = [])
    {
        self::$where = " WHERE $condition";
        self::$params = $params;
        return new static;
    }

    public static function orWhere($condition, $params = [])
    {
        self::$where .= " OR $condition";
        self::$params = array_merge(self::$params, $params);
        return new static;
    }
}

DB::getInstance(); // se conecta automáticamente