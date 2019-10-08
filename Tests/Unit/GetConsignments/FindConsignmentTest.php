<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\tests\GetConsignments;

use Exception;
use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use PHPUnit\Framework\TestCase;

class FindConsignmentTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testFindConsignment(): void
    {
        $apiKey = getenv('API_KEY');
        if ($apiKey == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $consignmentId = getenv('CONSIGNMENT_ID');
        if ($consignmentId == null) {
            echo "\033[31m Set consignment_id in 'Environment variables' before running UnitTest. Example: CONSIGNMENT_ID=1734535. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $collection = MyParcelCollection::find((int) $consignmentId, getenv('API_KEY'));

        $this->assertCount(1, $collection);
        $this->assertInternalType('string', $collection->getOneConsignment()->getStreet());
    }
}
