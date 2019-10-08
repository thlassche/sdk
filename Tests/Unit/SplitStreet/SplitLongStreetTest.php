<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\Tests\Unit\SplitStreet;

use MyParcelNL\Sdk\src\Exception\MissingFieldException;
use MyParcelNL\Sdk\src\Factory\ConsignmentFactory;
use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;
use PHPUnit\Framework\TestCase;

/**
 * Class SplitLongStreetTest
 *
 * @package MyParcelNL\Sdk\src\tests\Unit\SplitStreet
 */
class SplitLongStreetTest extends TestCase
{

    /**
     * For Dutch consignments the street should be divided into name, number and addition. This code tests whether the
     *  street is split properly.
     *
     * @covers       \MyParcelNL\Sdk\src\Model\ConsignmentFactory::setFullStreet
     * @dataProvider additionProvider()
     *
     * @param $carrierId
     * @param $country
     * @param $fullStreetTest
     * @param $street
     * @param $streetAdditionalInfo
     *
     * @throws MissingFieldException
     */
    public function testSplitStreet($carrierId, $country, $fullStreetTest, $street, $streetAdditionalInfo)
    {
        $consignment = (ConsignmentFactory::createByCarrierId($carrierId))
            ->setCountry($country)
            ->setFullStreet($fullStreetTest);

        $this->assertEquals(
            $street,
            $consignment->getFullStreet(true),
            'Street: ' . $street
        );

        $this->assertEquals(
            $streetAdditionalInfo,
            $consignment->getStreetAdditionalInfo(),
            'Street additional info: ' . $streetAdditionalInfo
        );
    }

    /**
     * Data for the test
     *
     * @return array
     */
    public function additionProvider()
    {
        return [
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'BE',
                'full_street_input'      => 'Ir. Mr. Dr. van Waterschoot van der Grachtstraat in Heerlen 14 t',
                'street'                 => 'Ir. Mr. Dr. van Waterschoot van der',
                'street_additional_info' => 'Grachtstraat in Heerlen 14 t',
            ],
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'NZ',
                'full_street_input'      => 'Taumatawhakatangihangakoauauotamateaturipukakapikimaungahoronukupokaiwhenuakitanatahu',
                'street'                 => 'Taumatawhakatangihangakoauauotamateaturipukakapikimaungahoronukupokaiwhenuakitanatahu',
                'street_additional_info' => '',
            ],
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'BE',
                'full_street_input'      => 'testtienpp testtienpp',
                'street'                 => 'testtienpp testtienpp',
                'street_additional_info' => '',
            ],
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'BE',
                'full_street_input'      => 'Wethouder Fierman Eduard Meerburg senior kade 14 t',
                'street'                 => 'Wethouder Fierman Eduard Meerburg senior',
                'street_additional_info' => 'kade 14 t',
            ],
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'NL',
                'full_street_input'      => 'Ir. Mr. Dr. van Waterschoot van der Grachtstraat 14 t',
                'street'                 => 'Ir. Mr. Dr. van Waterschoot van der 14 t',
                'street_additional_info' => 'Grachtstraat',
            ],
            [
                'carrier_id'             => PostNLConsignment::CARRIER_ID,
                'NL',
                'full_street_input'      => 'Koestraat 554 t',
                'street'                 => 'Koestraat 554 t',
                'street_additional_info' => '',
            ],
        ];
    }
}
