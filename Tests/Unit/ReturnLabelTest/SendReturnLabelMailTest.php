<?php declare(strict_types=1);

namespace MyParcelNL\Sdk\tests\ReturnLabelTest;

use Exception;
use MyParcelNL\Sdk\src\Exception\ApiException;
use MyParcelNL\Sdk\src\Exception\MissingFieldException;
use MyParcelNL\Sdk\src\Factory\ConsignmentFactory;
use MyParcelNL\Sdk\src\Helper\MyParcelCollection;
use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;
use PHPUnit\Framework\TestCase;

class SendReturnLabelMailTest extends TestCase
{
    /**
     * @return $this
     * @throws ApiException
     * @throws MissingFieldException
     */
    public function testSendReturnLabelMail()
    {
        if (getenv('API_KEY') == null) {
            echo "\033[31m Set MyParcel API-key in 'Environment variables' before running UnitTest. Example: API_KEY=f8912fb260639db3b1ceaef2730a4b0643ff0c31. PhpStorm example: http://take.ms/sgpgU5\n\033[0m";
            return $this;
        }

        $myParcelCollection = $this->getCollectionWithParentConsignment();
        $myParcelCollection->sendReturnLabelMails();

        $this->assertNotNull($myParcelCollection);
    }

    /**
     * @return MyParcelCollection
     * @throws MissingFieldException
     * @throws Exception
     */
    private function getCollectionWithParentConsignment()
    {
        $consignmentTest = $this->additionProviderNewConsignment();

        $myParcelCollection = new MyParcelCollection();

        $consignment = (ConsignmentFactory::createByCarrierId($consignmentTest['carrier_id']))
            ->setApiKey($consignmentTest['api_key'])
            ->setCountry($consignmentTest['cc'])
            ->setPerson($consignmentTest['person'])
            ->setCompany($consignmentTest['company'])
            ->setFullStreet($consignmentTest['full_street_input'])
            ->setPostalCode($consignmentTest['postal_code'])
            ->setCity($consignmentTest['city'])
            ->setEmail($consignmentTest['email'])
            ->setPhone($consignmentTest['phone']);

        $myParcelCollection
            ->addConsignment($consignment)
            ->setLinkOfLabels()
            ->setLatestData();

        return $myParcelCollection;
    }

    /**
     * Data for the test
     *
     * @return array
     */
    private function additionProviderNewConsignment()
    {
        return [
            'api_key' => getenv('API_KEY'),
            'carrier_id' => PostNLConsignment::CARRIER_ID,
            'cc' => 'NL',
            'person' => 'Piet',
            'email' => 'your_email@test.nl',
            'company' => 'Mega Store',
            'full_street_input' => 'Koestraat 55',
            'number_suffix' => '',
            'postal_code' => '2231JE',
            'city' => 'Katwijk',
            'phone' => '123-45-235-435',
            'label_description' => 'Label description',

        ];
    }
}
