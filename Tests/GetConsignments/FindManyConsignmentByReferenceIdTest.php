<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\tests\GetConsignments;

use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use MyParcelNL\Sdk\src\Model\MyParcelConsignment;
use PHPUnit\Framework\TestCase;

class FindManyConsignmentByReferenceIdTest extends TestCase
{
    /**
     * @return void
     */
    public function testFindManyConsignmentByReferenceId(): void
    {
        $apiKey = getenv('API_KEY');
        if ($apiKey == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $referenceIdsRaw = getenv('REFERENCE_IDS');
        if ($referenceIdsRaw == null) {
            echo "\033[31m Set reference_id in 'Environment variables' before running UnitTest. Example: REFERENCE_IDS=10952019-05-16,1077. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }
        $referenceIds = explode(',', $referenceIdsRaw);

        $collection = MyParcelCollection::findManyByReferenceId($referenceIds, getenv('API_KEY'));
        $this->checkCollection($collection, $referenceIds);
    }

    /**
     * @param MyParcelCollection|MyParcelConsignment[] $collection
     * @param int[]                                    $referenceId
     */
    public function checkCollection(MyParcelCollection $collection, array $referenceId): void
    {
        $this->assertCount(count($referenceId), $collection);
        $this->assertNotEmpty($collection, 'The returned collection is not the same as the given REFERENCE_IDS');

        foreach ($collection as $consignment) {
            $this->assertInternalType('string', $consignment->getStreet());
        }
    }
}
