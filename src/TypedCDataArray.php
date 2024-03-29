<?php

/**
 * This file is part of the sj-i/typed-cdata package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace TypedCData;

use FFI\CData;

/**
 * @template T of TypedCDataInterface
 */
class TypedCDataArray implements \ArrayAccess
{
    /** @var \FFI\CDataArray */
    private CData $cdata;
    /** @var class-string<T> $typed_cdata_class */
    private string $typed_cdata_class;
    /** @var array<int, T> */
    private array $typed_element_cache;

    /**
     * TypedCDataArray constructor.
     * @param \FFI\CDataArray $cdata
     * @param class-string<T> $typed_cdata_class
     */
    public function __construct(CData $cdata, string $typed_cdata_class)
    {
        $this->cdata = $cdata;
        $this->typed_cdata_class = $typed_cdata_class;
        $this->typed_element_cache = [];
    }

    public function offsetExists($offset)
    {
        return true;
    }

    /**
     * @param int $offset
     */
    public function offsetGet($offset): TypedCDataInterface
    {
        if (!isset($this->typed_element_cache[$offset])) {
            $this->typed_element_cache[$offset] = $this->typed_cdata_class::fromCData($this->cdata[$offset]);
        }
        return $this->typed_element_cache[$offset];
    }

    /**
     * @param int $offset
     * @param TypedCDataInterface $value
     */
    public function offsetSet($offset, $value)
    {
        $value->toCData($this->cdata[$offset]);
    }

    public function offsetUnset($offset)
    {
    }

    /**
     * @template T2 of TypedCDataInterface
     * @param \FFI\CDataArray $cdata
     * @param class-string<T2> $typed_cdata_class
     * @return self<T2>
     */
    public static function fromCData(CData $cdata, string $typed_cdata_class): TypedCDataArray
    {
        return new self($cdata, $typed_cdata_class);
    }

    public function toCData(?CData $cdata): CData
    {
        foreach ($this->typed_element_cache as $offset => $item) {
            assert($item instanceof TypedCDataInterface);
            $item->toCData($this->cdata[$offset]);
        }
        return $this->cdata;
    }
}
