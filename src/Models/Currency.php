<?php
declare(strict_types=1);

namespace App\Models;

use PDOException;

class Currency extends Model
{
    public static function saveDataFromApi(array $data): void
    {
        $query = 'REPLACE INTO currencies (currency_code, currency_name, exchange_rate, effective_date) VALUES ';
        $placeholders = array_fill(0, count($data), '(?, ?, ?, ?)');
        $query .= implode(', ', $placeholders);
        $sql = self::$conn->prepare($query);
        
        $i = 1;
        foreach ($data as $item) {
            $sql->bindValue($i++, $item['code']);
            $sql->bindValue($i++, $item['currency']);            
            $sql->bindValue($i++, $item['mid']);
            $sql->bindValue($i++, $item['effectiveDate']);
        }

        try {
            $sql->execute();
        } catch (PDOException $e) {
            dd("Wystąpił błąd przy zapisie do bazy walut do bazy");
        }
    }

    public static function getAll(): array
    {
        $query = 'SELECT * FROM currencies ORDER BY currency_code';

        try {
            $result = self::$conn->query($query);
        } catch (PDOException $e) {
            dd('Wystąpił problem przy pobieraniu rekordów z bazy');
        }
        
        $result = $result->fetchAll(self::$conn::FETCH_ASSOC);
        
        return $result;
    }

    public static function getByCode(string $currencyCode): array
    {
        $query = "SELECT * FROM currencies WHERE currency_code='$currencyCode'";
        $result = self::$conn->query($query);
        $result = $result->fetch(self::$conn::FETCH_ASSOC);

        return $result;
    }
}