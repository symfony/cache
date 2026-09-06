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

if (version_compare(phpversion('relay'), '0.50.0', '>=')) {
    /**
     * @internal
     */
    trait RelayCluster50Trait
    {
        public function fcall($name, $keys = [], $argv = [], $handler = null): mixed
        {
            return $this->initializeLazyObject()->fcall(...\func_get_args());
        }

        public function fcall_ro($name, $keys = [], $argv = [], $handler = null): mixed
        {
            return $this->initializeLazyObject()->fcall_ro(...\func_get_args());
        }

        public function himport($op, $hash, $fieldset = null, $fields = []): \Relay\Cluster|bool|int
        {
            return $this->initializeLazyObject()->himport(...\func_get_args());
        }

        public function msetex($kvals, $ttl = null): \Relay\Cluster|false|int
        {
            return $this->initializeLazyObject()->msetex(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RelayCluster50Trait
    {
    }
}
