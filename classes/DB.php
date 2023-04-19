<?php

namespace Controllers;

use PDO;
use PDOException;

class DB
{
    private static PDO $pdo;

    public static function connect()
    {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "stagetijd";

        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            $message = $error->getMessage();
        }
    }

    // Selects data from a MySQL database table.
    public static function select(string $table, array $data = []): array
    {
        // Get the number of elements in the array.
        $count = count($data);

        // Initialize a variable to hold the WHERE clause.
$where = '';
        // If there are multiple elements in the array, loop through them and construct the WHERE clause.
        if ($count > 1) {
            $where = 'WHERE ';
            $teller = 1;
            foreach ($data as $k => $v) {

                // If this is the last element in the array, append the column name and value without 'AND'.
                if ($teller === $count) {
                    $where .= ' ' . $k . ' = "' . $v . '"';
                }
                // If this is not the last element in the array, append the column name and value with 'AND'.
                else {
                    $where .= ' ' . $k . ' = "' . $v . '" AND';
                }

                // Increment the counter.
                $teller++;
            }
        } elseif ($count == 1) {
            $where = 'WHERE ';
            foreach ($data as $k => $v) {
                $where .= ' ' . $k . ' = "' . $v . '"';
            }
        }   
            $query = "SELECT * FROM $table $where";
        // Prepare the query statement.
        $stmt = self::$pdo->prepare($query);
        // Execute the query.
        $stmt->execute();


        // Return the selected rows as an array of associative arrays.
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // object
    }
        public static function join($mainTable, $col, $joinTables, array $joinCols, $id)
    {
        $table = $mainTable;
        $select = '*';

        $joins = '';
        $selects = '';

        if (!is_array($joinTables)) {
            $joinTables = [$joinTables];
            $col = [$col];
            $joinCols = [$joinCols];
        }

        foreach ($joinTables as $key => $joinTable) {
            $joins .= " JOIN $joinTable ON $table[$key].$col[$key] = $joinTable." . $joinCols[$key][0];
            $selects .= ", $joinTable." . $joinCols[$key][1];
        }

        $query = "SELECT $table[0].$select $selects FROM $table[0] $joins WHERE $id[0] = :id";
// echo $query;
        $stmt = self::$pdo->prepare($query);
        $stmt->execute(['id' => $id[1]]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);


        // return self::select($table, ['id' => $id[1]], $query);
    }
    
    // Inserts data into a MySQL database table.
    public static function insert(string $table, array $data = []) #:  int
    {
        // Initialize variables to hold the column names, values, and a counter.
        $columns = '';
        $values = '';
        $teller = 1;

        // Loop through the associative array of data.
        foreach ($data as $k => $array) {

            // Get the number of elements in the array.

            // Loop through the array's elements.
            if (count($data) != count($data, COUNT_RECURSIVE)) {
                $count = count($array);
                foreach ($array as $k => $v) {
                    // If this is the last element in the array, append the column name and value without a comma.
                    if ($teller === $count) {
                        $columns .= "`" . $k . "`";
                        $values .= ":" . $k;
                    }
                    // If this is not the last element in the array, append the column name and value with a comma.
                    else {
                        $columns .= "`" . $k . "`, ";
                        $values .= ":" . $k . ", ";
                    }
                    // Increment the counter.
                    $teller++;
                }
                $query = "INSERT INTO $table ($columns) VALUES ($values)";
                // echo $query;
                // Prepare the query statement.
                $stmt = self::$pdo->prepare($query);
                $columns = '';
                $values = '';
                $teller = 1;


                // Execute the query with the array of values.
                $stmt->execute($array);
            } else {
                $count = count($data);
                if ($teller === $count) {
                    $columns .= "`" . $k . "`";
                    $values .= ":" . $k;
                }
                // If this is not the last element in the array, append the column name and value with a comma.
                else {
                    $columns .= "`" . $k . "`, ";
                    $values .= ":" . $k . ", ";
                }

                // Increment the counter.
                $teller++;
            }
        }
        if (count($data) == count($data, COUNT_RECURSIVE)) {
            $array = $data;


            // Construct the INSERT query with the column names and values.
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            // echo $query;
            // Prepare the query statement.
            $stmt = self::$pdo->prepare($query);
// var_dump($query);
            // Execute the query with the array of values.
            $stmt->execute($array);
        }

        // Reset the variables for the next loop iteration.
        $columns = '';
        $values = '';
        $teller = 1;
        return self::$pdo->lastInsertId();

        // Return the number of affected rows.
    }


    public static function update(string $query, array $params = []): int
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public static function delete(string $query, array $params = [])
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($params);
    }
}
