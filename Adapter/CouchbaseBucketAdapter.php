<?php
/**
 * @copyright
 */

namespace Symfony\Component\Cache\Adapter;

use Couchbase\Bucket;
use Symfony\Component\Cache\Exception\CacheException;
use Symfony\Component\Cache\Exception\InvalidArgumentException;
use Symfony\Component\Cache\Marshaller\DefaultMarshaller;
use Symfony\Component\Cache\Marshaller\MarshallerInterface;

/**
 * @author Antonio Jose Cerezo Aranda <acerezo@elconfidencial.com>
 */
class CouchbaseBucketAdapter extends AbstractAdapter
{
    private const THIRTY_DAYS_IN_SECONDS = 2592000;
    private const MAX_KEY_LENGTH = 250;
    private const KEY_NOT_FOUND = 13;

    /** @var Bucket */
    private $bucket;

    /** @var MarshallerInterface */
    private $marshaller;

    public function __construct(\CouchbaseCluster $client, string $bucket, string $namespace = '', int $defaultLifetime = 0, array $options = [])
    {
        $this->init($client, $bucket, $namespace, $defaultLifetime, $options);
    }

    /**
     * @inheritdoc
     */
    public static function createConnection($servers, array $options = []) :\CouchbaseCluster
    {
        if (\is_string($servers)) {
            $servers = [$servers];
        } elseif (!\is_array($servers)) {
            throw new InvalidArgumentException(sprintf('CouchbaseAdapter::createClient() expects array or string as first argument, %s given.', \gettype($servers)));
        }

        if (!static::isSupported()) {
            throw new CacheException('Couchbase >= 2.6.0 is required');
        }

        set_error_handler(function ($type, $msg, $file, $line) { throw new \ErrorException($msg, 0, $type, $file, $line); });

        $newServers = [];
        try{
            $username = $options['username'] ?? '';
            $password = $options['password'] ?? '';

            foreach ($servers as $dsn) {
                if (\is_array($dsn)) {
                    continue;
                }

                if (0 !== strpos($dsn, 'couchbase:')) {
                    throw new InvalidArgumentException(sprintf('Invalid Couchbase DSN: %s does not start with "couchbase:"', $dsn));
                }

                preg_match('/^(?<protocol>couchbase(s)?):\/\/((?<username>[^@:]*+):(?<password>[^@]*+)@)?(?<cluster>.+)(\/.*)?/m', $dsn, $matchers);

//                if ('couchbases' === $matchers['protocol']) {
//                    $
//                }
                $username = $matchers['username'] ?: $username;
                $password = $matchers['password'] ?: $password;
                $newServers += \explode(',', $matchers['cluster']);
            }

            $servers = $newServers ?? $servers;
            $connectionString = $matchers['protocol'].'://'.\implode(',', $servers);

            $client = new \CouchbaseCluster($connectionString);
            $client->authenticateAs($username, $password);
            return $client;

        } finally {
            restore_error_handler();
        }
        
    }

    /**
     * @return bool
     */
    public static function isSupported() :bool
    {
        return \extension_loaded('couchbase') && version_compare(phpversion('couchbase'), '2.6.0', '>=');
    }

    /**
     * @param \CouchbaseCluster        $client
     * @param string                   $bucket
     * @param string                   $namespace
     * @param int                      $defaultLifetime
     * @param array                    $options
     * @param MarshallerInterface|null $marshaller
     *
     * @throws CacheException
     */
    private function init(
        \CouchbaseCluster $client,
        string $bucket,
        string $namespace,
        int $defaultLifetime,
        array $options = [],
        ?MarshallerInterface $marshaller = null
    ) :void {

        if (!static::isSupported()) {
            throw new CacheException('Couchbase >= 2.6.0 is required');
        }

        $this->maxIdLength = static::MAX_KEY_LENGTH;

        $this->bucket = $client->openBucket($bucket);

        $this->bucket->operationTimeout = $options['operationTimeout'] ?? $this->bucket->operationTimeout;
        $this->bucket->configTimeout = $options['configTimeout'] ?? $this->bucket->configTimeout;
        $this->bucket->configNodeTimeout = $options['configNodeTimeout'] ?? $this->bucket->configNodeTimeout;

        parent::__construct($namespace, $defaultLifetime);
        $this->enableVersioning();
        $this->marshaller = $marshaller ?? new DefaultMarshaller();
    }

    /**
     * @inheritDoc
     */
    protected function doFetch(array $ids)
    {
        $resultsCouchbase = $this->bucket->get($ids);

        $results = [];
        foreach ($resultsCouchbase as $key => $value) {
            if (null !== $value->error) {
                continue;
            }
            $results[$key] = $this->marshaller->unmarshall($value->value);
        }

        return $results;
    }

    /**
     * @inheritDoc
     */
    protected function doHave($id): bool
    {
        return false !== $this->bucket->get($id);
    }

    /**
     * @inheritDoc
     */
    protected function doClear($namespace): bool
    {
        if ('' === $namespace) {
            $this->bucket->manager()->flush();

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function doDelete(array $ids):bool
    {
        $results = $this->bucket->remove(\array_values($ids));

        foreach ($results as $key => $result) {
            if (null !== $result->error && static::KEY_NOT_FOUND !== $result->error->getCode()) {
                continue;
            }
            unset($results[$key]);
        }
        return (0 === \count($results));
    }

    /**
     * @inheritDoc
     */
    protected function doSave(array $values, $lifetime)
    {

        if (!$values = $this->marshaller->marshall($values, $failed)) {
            return $failed;
        }

        $lifetime = $this->normalizeExpiry($lifetime);


        $ko = [];
        foreach ($values as $key => $value) {
            $result = $this->bucket->upsert($key, $value, ['expiry' => $lifetime]);

            if (null !== $result->error) {
                $ko[$key] = $result;
            }
        }

        return [] === $ko ? true : $ko;
    }

    /**
     * @param int $expiry
     *
     * @return int
     */
    private function normalizeExpiry(int $expiry) :int
    {
        if ($expiry && $expiry > static::THIRTY_DAYS_IN_SECONDS) {
            $expiry += time();
        }

        return $expiry;
    }

}