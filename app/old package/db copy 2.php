<?php

namespace App\Packages\DB;

use PDO;
use Exception;

class DB
{
    private static $pdo;
    private static $dsn;
    private static $username;
    private static $password;
    private static $options = [];
    protected static $where = '';
    protected static $params = [];

    public static function connect($dsn, $username = null, $password = null, $options = [])
    {
        self::$dsn = $dsn;
        self::$username = $username;
        self::$password = $password;
        self::$options = $options;
    }

    private static function query($sql, $params = [])
    {
        if (!self::$pdo) {
            self::$pdo = new PDO(self::$dsn, self::$username, self::$password, self::$options);
        }
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function select($table, $columns = ['*'])
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM $table";
        return self::query($sql);
    }

    public static function first($table, $columns = ['*'])
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM $table LIMIT 1";
        return self::query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public static function find($table, $id, $columns = ['*'])
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM $table WHERE id=?";
        return self::query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public static function findAll($table, $columns = ['*'], $where = null, $params = [])
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return self::query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findOne($table, $columns = ['*'], $where = null, $params = [])
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return self::query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = str_repeat("?, ", count($data) - 1) . "?";
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        self::query($sql, array_values($data));
        return self::$pdo->lastInsertId();
    }

    public static function update($table, $data, $where = null, $params = [])
    {
        $fields = array_keys($data);
        $params = array_merge(array_values($data), $params);
        $set = implode("=?, ", $fields) . "=?";
        $sql = "UPDATE $table SET $set";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return self::query($sql, $params)->rowCount();
    }

    public static function delete($table, $where = null, $params = [])
    {
        $sql = "DELETE FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        return self::query($sql, $params)->rowCount();
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
