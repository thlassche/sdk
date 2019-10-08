<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\Tests\Unit\GetConsignments;

use Exception;
use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use PHPUnit\Framework\TestCase;

class FindConsignmentByReferenceIdTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testFindConsignmentByReferenceId(): void
    {
        $apiKey = getenv('API_KEY');
        if ($apiKey == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $referenceId = getenv('REFERENCE_ID');
        if ($referenceId == null) {
            echo "\033[31m Set reference_id in 'Environment variables' before running UnitTest. Example: REFERENCE_ID=order 12. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";

            return;
        }

        $collection = MyParcelCollection::findByReferenceId($referenceId, getenv('API_KEY'));

        $this->assertCount(1, $collection);
        $this->assertInternalType('string', $collection->getOneConsignment()->getStreet());
    }
}
