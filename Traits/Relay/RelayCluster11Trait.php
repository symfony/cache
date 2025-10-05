<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Cache\Traits\Relay;

if (version_compare(phpversion('relay'), '0.11.0', '>=')) {
    /**
     * @internal
     */
    trait RelayCluster11Trait
    {
        public function flushSlotCache(): bool
        {
            return $this->initializeLazyObject()->flushSlotCache(...\func_get_args());
        }

        public function fullscan($match = null, $count = 0, $type = null): \Generator|false
        {
            return $this->initializeLazyObject()->fullscan(...\func_get_args());
        }

        public function getdel($key): mixed
        {
            return $this->initializeLazyObject()->getdel(...\func_get_args());
        }

        public function hexpire($hash, $ttl, $fields, $mode = null): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hexpire(...\func_get_args());
        }

        public function hexpireat($hash, $ttl, $fields, $mode = null): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hexpireat(...\func_get_args());
        }

        public function hexpiretime($hash, $fields): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hexpiretime(...\func_get_args());
        }

        public function hpersist($hash, $fields): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hpersist(...\func_get_args());
        }

        public function hpexpire($hash, $ttl, $fields, $mode = null): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hpexpire(...\func_get_args());
        }

        public function hpexpireat($hash, $ttl, $fields, $mode = null): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hpexpireat(...\func_get_args());
        }

        public function hpexpiretime($hash, $fields): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hpexpiretime(...\func_get_args());
        }

        public function hpttl($hash, $fields): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->hpttl(...\func_get_args());
        }

        public function httl($hash, $fields): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->httl(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RelayCluster11Trait
    {
    }
}
