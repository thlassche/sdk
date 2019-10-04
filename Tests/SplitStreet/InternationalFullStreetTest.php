<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\tests\SplitStreet;

use MyParcelNL\Sdk\src\Exception\MissingFieldException;
use MyParcelNL\Sdk\src\Factory\ConsignmentFactory;
use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;
use PHPUnit\Framework\TestCase;

/**
 * Class InternationalFullStreetTest
 *
 * @package MyParcelNL\Sdk\src\tests\SplitStreet
 */
class InternationalFullStreetTest extends TestCase
{
    /**
     * For Dutch consignments the street should be divided into name, number and addition. For shipments to other
     *  the address countries should be on one line. For this it is required first fill out a country. This code tests
     *  whether the street has remained the same after the request.
     *
     * @covers       \MyParcelNL\Sdk\src\Model\AbstractConsignment::getFullStreet
     * @dataProvider additionProvider()
     *
     * @param $carrierId
     * @param $cc
     * @param $fullStreet
     *
     * @throws MissingFieldException
     */
    public function testSplitStreet($carrierId, $cc, $fullStreet)
    {
        $consignment = (ConsignmentFactory::createByCarrierId($carrierId))
            ->setCountry($cc)
            ->setFullStreet($fullStreet);

        $this->assertEquals($fullStreet, $consignment->getFullStreet(), 'Full street: ' . $fullStreet);
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
                'carrier_id'  => PostNLConsignment::CARRIER_ID,
                'cc'          => 'FR',
                'full_street' => 'No. 7 street',
            ],
        ];
    }
}
