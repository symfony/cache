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

use Relay\Cluster;
use Relay\Relay;

if (version_compare(phpversion('relay'), '0.12.0', '>=')) {
    /**
     * @internal
     */
    trait WaitaofTrait
    {
    }
} else {
    /**
     * @internal
     */
    trait WaitaofTrait
    {

        public function waitaof(array|string $key_or_address, int $numlocal, int $numremote, int $timeout): Relay|array|false
        {
            return $this->initializeLazyObject()->waitaof(...\func_get_args());
        }
    }
}
