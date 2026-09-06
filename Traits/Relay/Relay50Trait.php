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
    trait Relay50Trait
    {
        public function himport($op, $hash = null, $fieldset = null, $fields = []): \Relay\Relay|bool|int
        {
            return $this->initializeLazyObject()->himport(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay50Trait
    {
    }
}
