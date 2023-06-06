<?php
declare(strict_types=1);

namespace App\Models;

use PDOException;

class Exchange extends Model
{
    public static function saveExchange(array $sourceCurrency, array $targetCurrency, float $amount, float $exchangeRate, float $exchangeResult): void
    {
        $query = 'INSERT INTO exchanges 
        (source_currency_code, target_currency_code, amount, exchange_rate, exchange_result)
        VALUES
        (?, ?, ?, ?, ?)';
        
        $sql = self::$conn->prepare($query);
        $sql->bindValue(1, $sourceCurrency['currency_code']);
        $sql->bindValue(2, $targetCurrency['currency_code']);
        $sql->bindValue(3, $amount);
        $sql->bindValue(4, $exchangeRate);
        $sql->bindValue(5, $exchangeResult);

        try {
            $sql->execute();
        } catch (PDOException $e) {
            dd("Wystąpił błąd przy zapisie do bazy, proszę sprawdzić kwotę");
        }
    }

    public static function getAll(): array
    {
        $query = "SELECT e.source_currency_code, e.target_currency_code, e.amount, e.exchange_rate, e.exchange_result,
            c1.currency_name as source_currency_name,
            c2.currency_name as target_currency_name
            FROM exchanges AS e
            JOIN currencies AS c1 ON e.source_currency_code = c1.currency_code
            JOIN currencies AS c2 ON e.target_currency_code = c2.currency_code 
        ";

        $result = self::$conn->query($query);
        $result = $result->fetchAll(self::$conn::FETCH_ASSOC);
        
        return $result;
    }
}