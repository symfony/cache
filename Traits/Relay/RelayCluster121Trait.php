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

if (version_compare(phpversion('relay'), '0.12.1', '>=')) {
    /**
     * @internal
     */
    trait RelayCluster121Trait
    {
        public function hgetWithMeta($hash, $member): \Relay\Cluster|array|false
        {
            return $this->initializeLazyObject()->getWithMeta(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait RelayCluster121Trait
    {
    }
}
