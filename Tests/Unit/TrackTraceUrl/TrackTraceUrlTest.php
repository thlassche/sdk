<?php

namespace MyParcelNL\Sdk\Tests\Unit\TrackTraceUrl;

use MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment;
use PHPUnit\Framework\TestCase;

/**
 * Class TrackTraceUrlTest
 *
 * @package MyParcelNL\Sdk\Tests\Unit\TrackTraceUrl
 */
class TrackTraceUrlTest extends TestCase
{

    /**
     * @covers       \MyParcelNL\Sdk\src\Model\Consignment\PostNLConsignment::TrackTraceUrl
     * @dataProvider additionProvider()
     *
     * @param $barcode
     * @param $postalCode
     * @param $countryCode
     */
    public function testTrackTrace($barcode, $postalCode, $countryCode)
    {
        $consignment   = new PostNLConsignment();
        $trackTraceUrl = $consignment->getBarcodeUrl($barcode, $postalCode, $countryCode);
        $this->assertSame(
            "https://myparcel.me/track-trace/$barcode/$postalCode/$countryCode",
            $trackTraceUrl,
            'The track-trace url is not the same as the result.'
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
                'barcode'     => '1234567890',
                'postal_code' => '2131BC',
                'cc'          => 'NL',
            ],
        ];
    }
}
