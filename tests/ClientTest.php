<?php


namespace SzuniSoft\Mnb\Tests;


use PHPUnit\Framework\TestCase;
use stdClass;
use SzuniSoft\Mnb\Client;

class ClientTest extends TestCase {

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $soapClient;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new Client();
        $this->soapClient = $this->getMockFromWsdl('http://www.mnb.hu/arfolyamok.asmx?wsdl');
        $this->client->setClient($this->soapClient);
    }

    /** @test */
    public function it_can_return_with_currencies()
    {
        $result = new stdClass();
        $result->GetCurrenciesResult = '<MNBCurrencies><Currencies><Curr>HUF</Curr><Curr>EUR</Curr></Currencies></MNBCurrencies>';
        $this->soapClient
            ->method('GetCurrencies')
            ->willReturn($result);

        $this->assertEquals([
            'HUF', 'EUR'
        ],$this->client->currencies());
    }

    /** @test */
    public function it_can_return_with_current_exchange_rates()
    {
        $result = new stdClass();
        $result->GetCurrentExchangeRatesResult = '<MNBCurrentExchangeRates><Day date="2018-08-01"><Rate unit="1" curr="AUD">203,66000</Rate><Rate unit="1" curr="BGN">164,23000</Rate></Day></MNBCurrentExchangeRates>';
        $this->soapClient
            ->method('GetCurrentExchangeRates')
            ->willReturn($result);

        $currencies = $this->client->currentExchangeRates();
        $this->assertEquals(2, count($currencies));
        $this->assertEquals(1, $currencies[0]->getUnit());
        $this->assertEquals('AUD', $currencies[0]->getCode());
        $this->assertEquals(203.66, $currencies[0]->getAmount());
    }

    /** @test */
    public function it_can_offer_date_for_exchange_rate_list()
    {
        $result = new stdClass();
        $result->GetCurrentExchangeRatesResult = '<MNBCurrentExchangeRates><Day date="2018-08-01"><Rate unit="1" curr="AUD">203,66000</Rate><Rate unit="1" curr="BGN">164,23000</Rate></Day></MNBCurrentExchangeRates>';
        $this->soapClient
            ->method('GetCurrentExchangeRates')
            ->willReturn($result);

        $this->client->currentExchangeRates($date);
        $this->assertEquals('2018-08-01', $date);
    }

    /** @test */
    public function it_can_return_with_currency_specific_info()
    {
        $result = new stdClass();
        $result->GetCurrentExchangeRatesResult = '<MNBCurrentExchangeRates><Day date="2018-08-01"><Rate unit="1" curr="AUD">203,66000</Rate><Rate unit="1" curr="BGN">164,23000</Rate></Day></MNBCurrentExchangeRates>';
        $this->soapClient
            ->method('GetCurrentExchangeRates')
            ->willReturn($result);

        $currency = $this->client->currentExchangeRate('BGN', $date);
        $this->assertNotNull($currency);
        $this->assertEquals('BGN', $currency->getCode());
        $this->assertEquals(1, $currency->getUnit());
        $this->assertEquals(164.23, $currency->getAmount());
        $this->assertEquals('2018-08-01', $date);
    }

    /** @test */
    public function soap_client_proxy_is_accessible()
    {
        $xml = '<MNBCurrentExchangeRates><Day date="2018-08-01"><Rate unit="1" curr="AUD">203,66000</Rate><Rate unit="1" curr="BGN">164,23000</Rate></Day></MNBCurrentExchangeRates>';
        $result = new stdClass();
        $result->GetCurrentExchangeRatesResult = $xml;
        $this->soapClient
            ->method('GetCurrentExchangeRates')
            ->willReturn($result);

        $result = $this->client->GetCurrentExchangeRates(null);
        $this->assertInstanceOf(stdClass::class, $result);
        $this->assertEquals($xml, (string) $result->GetCurrentExchangeRatesResult);
    }
}