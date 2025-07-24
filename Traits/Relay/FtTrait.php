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

if (version_compare(phpversion('relay'), '0.9.0', '>=')) {
    /**
     * @internal
     */
    trait FtTrait
    {
        public function ftAggregate($index, $query, $options = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftAggregate(...\func_get_args());
        }

        public function ftAliasAdd($index, $alias): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftAliasAdd(...\func_get_args());
        }

        public function ftAliasDel($alias): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftAliasDel(...\func_get_args());
        }

        public function ftAliasUpdate($index, $alias): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftAliasUpdate(...\func_get_args());
        }

        public function ftAlter($index, $schema, $skipinitialscan = false): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftAlter(...\func_get_args());
        }

        public function ftConfig($operation, $option, $value = null): \Relay\Relay|array|bool
        {
            return $this->initializeLazyObject()->ftConfig(...\func_get_args());
        }

        public function ftCreate($index, $schema, $options = null): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftCreate(...\func_get_args());
        }

        public function ftCursor($operation, $index, $cursor, $options = null): \Relay\Relay|array|bool
        {
            return $this->initializeLazyObject()->ftCursor(...\func_get_args());
        }

        public function ftDictAdd($dict, $term, ...$other_terms): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->ftDictAdd(...\func_get_args());
        }

        public function ftDictDel($dict, $term, ...$other_terms): \Relay\Relay|false|int
        {
            return $this->initializeLazyObject()->ftDictDel(...\func_get_args());
        }

        public function ftDictDump($dict): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftDictDump(...\func_get_args());
        }

        public function ftDropIndex($index, $dd = false): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftDropIndex(...\func_get_args());
        }

        public function ftExplain($index, $query, $dialect = 0): \Relay\Relay|false|string
        {
            return $this->initializeLazyObject()->ftExplain(...\func_get_args());
        }

        public function ftExplainCli($index, $query, $dialect = 0): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftExplainCli(...\func_get_args());
        }

        public function ftInfo($index): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftInfo(...\func_get_args());
        }

        public function ftProfile($index, $command, $query, $limited = false): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftProfile(...\func_get_args());
        }

        public function ftSearch($index, $query, $options = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftSearch(...\func_get_args());
        }

        public function ftSpellCheck($index, $query, $options = null): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftSpellCheck(...\func_get_args());
        }

        public function ftSynDump($index): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftSynDump(...\func_get_args());
        }

        public function ftSynUpdate($index, $synonym, $term_or_terms, $skipinitialscan = false): \Relay\Relay|bool
        {
            return $this->initializeLazyObject()->ftSynUpdate(...\func_get_args());
        }

        public function ftTagVals($index, $tag): \Relay\Relay|array|false
        {
            return $this->initializeLazyObject()->ftTagVals(...\func_get_args());
        }
    }
} else {
    /**
     * @internal
     */
    trait FtTrait
    {
    }
}
