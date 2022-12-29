<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Service\ValClient;
use DateTime;
use GuzzleHttp\Exception\GuzzleException;

class ConsoleController
{
    private CurrencyRepository $currencyRepository;
    private ValClient $valClient;


    public function __construct(CurrencyRepository $CurrencyRepository,
                                ValClient $valClient)
    {
        $this->currencyRepository   = $CurrencyRepository;
        $this->valClient            = $valClient;
    }

    /**
     * @throws GuzzleException
     */
    public function refreshValutes()
    {
        $arrVal = $this->valClient->getForeignCurrencyMarket();
        $this->currencyRepository->deleteOldValute();
        $this->saveValute($arrVal);
    }

    private function saveValute(array $arrVal)
    {
        $data = strtotime($arrVal['Date']);
        $dataTime = new DateTime();
        $dataTime->setTimestamp($data);
        $arrVal = $arrVal['Valute'];

        foreach ($arrVal as $key)
        {
            $currency = new Currency
            (
                $key['NumCode'],
                $key['CharCode'],
                $key['Nominal'],
                $key['Name'],
                $key['Value'],
                $key['Previous'],
                $dataTime
            );
            $this->currencyRepository->add($currency, true);
        }
    }
}