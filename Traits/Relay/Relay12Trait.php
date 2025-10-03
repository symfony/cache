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

if (version_compare(phpversion('relay'), '0.12.0', '>=')) {
    /**
     * @internal
     */
    trait Relay12Trait
    {
        public function delifeq($key, $value): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->delifeq(...\func_get_args());
        }

        public function vadd($key, $values, $element, $options = null): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->vadd(...\func_get_args());
        }

        public function vcard($key): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->vcard(...\func_get_args());
        }

        public function vdim($key): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->vdim(...\func_get_args());
        }

        public function vemb($key, $element, $raw = false): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->vemb(...\func_get_args());
        }

        public function vgetattr($key, $element, $raw = false): \Relay\Relay|array|false|string
        {
            return $this->initializeLazyObject()->vgetattr(...\func_get_args());
        }

        public function vinfo($key): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->vinfo(...\func_get_args());
        }

        public function vismember($key, $element): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->vismember(...\func_get_args());
        }

        public function vlinks($key, $element, $withscores): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->vlinks(...\func_get_args());
        }

        public function vrandmember($key, $count = 0): \Relay\Relay|array|false|string
        {
            return $this->initializeLazyObject()->vrandmember(...\func_get_args());
        }

        public function vrange($key, $min, $max, $count = -1): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->vrange(...\func_get_args());
        }

        public function vrem($key, $element): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->vrem(...\func_get_args());
        }

        public function vsetattr($key, $element, $attributes): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->vsetattr(...\func_get_args());
        }

        public function vsim($key, $member, $options = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->vsim(...\func_get_args());
        }

        public function xdelex($key, $ids, $mode = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->xdelex(...\func_get_args());
        }

        public function xackdel($key, $group, $ids, $mode = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->xackdel(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait Relay12Trait
    {
    }
}
