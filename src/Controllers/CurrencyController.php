<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Currency;
use App\Models\Exchange;

class CurrencyController extends Controller
{
    public function exchangeForm(): void
    {
        $currencies  = Currency::getAll();
        $exchanges = Exchange::getAll();

        $this->view->render('calculateRate', [
            'currencies' => $currencies,
            'exchanges' => $exchanges
        ]);
    }

    public function exchange(): void
    {
        if ($this->request->isPost() && $this->request->hasPostParams()) {

            $sourceCurrencyCode = trim(htmlspecialchars($this->request->postParam('source_currency_code')));
            $targetCurrencyCode = trim(htmlspecialchars($this->request->postParam('target_currency_code')));
            $amount = trim(htmlspecialchars($this->request->postParam('amount')));

            if (!empty($sourceCurrencyCode) && !empty($targetCurrencyCode) && !empty($amount)) {

                if ($sourceCurrencyCode == $targetCurrencyCode) {
                    $this->redirect('/?c=currency&m=exchangeForm', [
                        'error',
                        'Waluta źródłowa i doeclowa jest taka sama'
                    ]);
                }

                $amount = (float) str_replace(',', '.', $amount);

                if (!is_float($amount)) {
                    $this->redirect('/?c=currency&m=exchangeForm', [
                        'error',
                        'Nie podano kwoty'
                    ]);
                }

                $sourceCurrency = Currency::getByCode($sourceCurrencyCode);
                $targetCurrency = Currency::getByCode($targetCurrencyCode);

                $exchangeRate = round($sourceCurrency['exchange_rate'] / $targetCurrency['exchange_rate'], 6);
                $exchangeResult = round($exchangeRate * $amount, 2);

                Exchange::saveExchange($sourceCurrency, $targetCurrency, $amount, $exchangeRate, $exchangeResult);

                $this->redirect('/?c=currency&m=exchangeForm', [
                    'success',
                    "Przewalutowanie kwoty: <b>$amount</b> z waluty <b>{$sourceCurrency['currency_name']}</b> 
                    na walutę <b>{$targetCurrency['currency_name']}</b>. Wynik: <b>$exchangeResult</b> kurs: <b>$exchangeRate</b>"
                ]);
                
            } else {
                $this->redirect('/?c=currency&m=exchangeForm', [
                    'error',
                    'Błąd'
                ]);
            }
        }
    }

    public function downloadFromApi(): void
    {
        $apilinks = [
            'http://api.nbp.pl/api/exchangerates/tables/A?format=json',
            'http://api.nbp.pl/api/exchangerates/tables/B?format=json'
        ];
        
        $currencies = [];
        foreach ($apilinks as $link) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $link);

            $response = json_decode(curl_exec($ch), true)[0];

            curl_close($ch);

            $effectiveDate = $response['effectiveDate'];

            foreach ($response['rates'] as $currenciesDetails){
                $currenciesDetails['effectiveDate'] = $effectiveDate;
                $currencies[] = $currenciesDetails;
            } 
        }

        Currency::saveDataFromApi($currencies);

        $this->redirect('/', ['success', 'Pobrano najnowsze kursy walut']);
    }
}