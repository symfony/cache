<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Cache\Traits;

/**
 * This file acts as a wrapper to the RedisCluster implementation
 *
 * Calls are made to nodes via RedisCluster->{method}($host, ...args)'
 *  according to https://github.com/phpredis/phpredis/blob/develop/cluster.markdown#directed-node-commands
 *
 * @author Jack Thomas <jack.thomas@solidalpha.com>
 *
 * @internal
 */
class RedisClusterNodeProxy
{
    /** @var array */
    private $host;

    /** @var RedisClusterProxy|RedisCluster */
    private $redis;

    /**
     * @param array $redisHost
     * @param \RedisCluster|RedisClusterProxy $redis
     */
    public function __construct(array $host, $redis)
    {
        $this->host = $host;
        $this->redis = $redis;

        /*
        Old Implementation:
        use \Redis;

        $h = new Redis();
        $h->connect($host[0], $host[1]);
        */
    }

    public function __call(string $method, array $args)
    {
        return $this->redis->{$method}($this->host, ...$args);
    }
}
