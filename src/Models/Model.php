<?php
declare(strict_types=1);

namespace App\Models;

use PDO;
use PDOException;

abstract class Model
{
    protected static PDO $conn;

    public static function createConnection(array $config): void
    {
        try {
            static::$conn = new PDO("mysql:dbname={$config['DATABASE']};host={$config['HOST']}", $config['USERNAME'], $config['PASSWORD']);
        } catch (PDOException $e) {
            exit('Błąd przy łączeniu z bazą');
        }
        
        self::createTablesIfNotExists();
    }

    private static function createTablesIfNotExists(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS currencies (
            currency_code char(3) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
            currency_name char(60) CHARACTER SET utf8mb4 NOT NULL,
            exchange_rate float(10,6) NOT NULL,
            effective_date date NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (currency_code)
          )";

        try {
            $sql = self::$conn->query($query);
            $sql->execute();
        } catch (PDOException $e) {
            dd('Nie udało się utworzyć tabeli `currencies`');
        }

        $query = "CREATE TABLE IF NOT EXISTS exchanges (
            id int NOT NULL AUTO_INCREMENT,
            source_currency_code char(3) CHARACTER SET utf8mb4 NOT NULL,
            target_currency_code char(3) CHARACTER SET utf8mb4 NOT NULL,
            amount float(20,2) NOT NULL,
            exchange_rate float(10,6) NOT NULL,
            exchange_result float(20,2) NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY source_currency (source_currency_code),
            KEY target_currency (target_currency_code),
            CONSTRAINT source_currency FOREIGN KEY (source_currency_code) REFERENCES currencies (currency_code),
            CONSTRAINT target_currency FOREIGN KEY (target_currency_code) REFERENCES currencies (currency_code)
          )";

        try {
            $sql = self::$conn->query($query);
            $sql->execute();
        } catch (PDOException $e) {
            dd('Nie udało się utworzyć tabeli `exchanges`');
        }
    }
}