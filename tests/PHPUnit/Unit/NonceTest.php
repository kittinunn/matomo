<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Tests\Unit;

use Piwik\Config;
use Piwik\Nonce;
use Piwik\Url;

/**
 * @backupGlobals enabled
 */
class NonceTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Dataprovider for acceptable origins test
     */
    public function getAcceptableOriginsTestData()
    {
        return array(
            // HTTP_HOST => expected
            array('example.com', array('http://example.com', 'https://example.com', 'http://example.com:80', 'https://example.com:443', )),
            array('example.com:80', array('http://example.com', 'https://example.com', 'http://example.com:80', 'https://example.com:80')),
            array('example.com:443', array('http://example.com', 'https://example.com', 'https://example.com:443')),
            array('example.com:8080', array('http://example.com', 'https://example.com', 'http://example.com:8080', 'https://example.com:8080')),
        );
    }

    /**
     * @dataProvider getAcceptableOriginsTestData
     * @group Core
     */
    public function test_getAcceptableOrigins($host, $expected)
    {
        Config::getInstance()->General['enable_trusted_host_check'] = 0;
        Url::setHost($host);
        Config::getInstance()->General['trusted_hosts'] = array('example.com');
        $this->assertEquals($expected, Nonce::getAcceptableOrigins(), $host);
    }
}
