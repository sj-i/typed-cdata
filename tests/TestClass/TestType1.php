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

use TypedCData\TypedCDataInterface;

final class TestType1 implements TypedCDataInterface
{
    use TypedCDataDefaultImplementationTrait;

    public int $int_field;

    public static function getCTypeName(): string
    {
        return 'struct test_type1';
    }

    public function __construct(int $int_field = 0)
    {
        $this->int_field = $int_field;
    }
}
