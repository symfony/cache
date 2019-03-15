<?php

namespace Symfony\Component\Cache\Tests\Adapter;

use Couchbase\Bucket;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\CouchbaseBucketAdapter;

/**
 * @author Antonio Jose Cerezo Aranda <acerezo@elconfidencial.com>
 */
class CouchbaseBucketAdapterTest extends AdapterTestCase
{

    protected $skippedTests = [
//        'testBasicUsageWithLongKey' => 'The maximum number of characters that couchbase supports in its keys is 250 characters'
    ];

    /** @var \CouchbaseCluster */
    protected static $client;


    public static function setupBeforeClass()
    {
        if (!CouchbaseBucketAdapter::isSupported()) {
            self::markTestSkipped('Extension couchbase >=2.6.0 required.');
        }
        self::$client = AbstractAdapter::createConnection('couchbase://'.getenv('COUCHBASE_HOST'),
            ['username' => \getenv('COUCHBASE_USER'), 'password' => \getenv('COUCHBASE_PASS')]
        );

        try {
            self::$client->openBucket('foo');
        } catch (\Exception $exception) {
            self::markTestSkipped('Couchbase error: '.strtolower($exception->getMessage()));
        }
    }

    /**
     * @inheritDoc
     */
    public function createCachePool($defaultLifetime = 0)
    {
        $client = $defaultLifetime
            ? AbstractAdapter::createConnection('couchbase://'
                .\getenv('COUCHBASE_USER')
                .':'.\getenv('COUCHBASE_PASS')
                .'@'.\getenv('COUCHBASE_HOST'))
            : self::$client;

        return new CouchbaseBucketAdapter($client, 'foo', str_replace('\\', '.', __CLASS__), $defaultLifetime);
    }

    /**
     * @test
     * @expectedException  \Symfony\Component\Cache\Exception\InvalidArgumentException
     */
    public function createConnectionShouldThrowInvalidArgumentException() :void
    {
        CouchbaseBucketAdapter::createConnection(new \DateTime());
    }
}
