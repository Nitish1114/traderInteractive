<?php
abstract class AbstractService
{
    public static function getConnection()
    {
        // Ideally we'd use Laravel with Eloquest to make queries and have environment specific DB properties.
        $conn = new mysqli('localhost', 'root', 'root', 'mydb');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            exit;
        }
        return $conn;
    }
}