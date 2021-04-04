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

namespace TypedCData\TestClass;

use FFI;

final class FFILoader
{
    private static ?self $instance;
    public FFI $ffi;

    private function __construct(FFI $ffi)
    {
        $this->ffi = $ffi;
    }

    private static function load(): FFI
    {
        return FFI::cdef(
            file_get_contents(__DIR__ . '/header.h')
        );
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(self::load());
        }
        return self::$instance;
    }
}
