<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\tests\GetConsignments;

use Exception;
use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use MyParcelNL\Sdk\src\Model\MyParcelConsignment;
use PHPUnit\Framework\TestCase;

class FindManyConsignmentTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testFindManyConsignment(): void
    {
        $apiKey = getenv('API_KEY');
        if ($apiKey == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $consignmentIdsRaw = getenv('CONSIGNMENT_IDS');
        if ($consignmentIdsRaw == null) {
            echo "\033[31m Set consignment_id in 'Environment variables' before running UnitTest. Example: CONSIGNMENT_IDS=47964049,47964050,47964051. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }
        $consignmentIds = explode(",", $consignmentIdsRaw);

        $collection = MyParcelCollection::findMany($consignmentIds, getenv('API_KEY'));
        $this->checkCollection($collection, $consignmentIds);

    }

    /**
     * @param MyParcelCollection|MyParcelConsignment[] $collection
     * @param int[]                                    $consignmentIds
     */
    public function checkCollection(MyParcelCollection $collection, array $consignmentIds): void
    {
        $this->assertCount(count($consignmentIds), $collection);
        $this->assertNotEmpty($collection, 'The returned collection is not the same as the given CONSIGNMENT_IDS');

        foreach ($collection as $consignment) {
            $this->assertInternalType('string', $consignment->getStreet());
        }
    }
}
