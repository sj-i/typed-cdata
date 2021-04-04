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

use TypedCData\TypedCDataArray;
use TypedCData\TypedCDataInterface;

final class TestType2 implements TypedCDataInterface
{
    use TypedCDataDefaultImplementationTrait;

    /** @var TypedCDataArray<TestType1> */
    public TypedCDataArray $array_of_struct;

    public static function getCTypeName(): string
    {
        return 'struct test_type2';
    }

    /**
     * @param TypedCDataArray<TestType1>|null $array_of_struct
     */
    public function __construct(
        ?TypedCDataArray $array_of_struct = null
    ) {
        $this->array_of_struct = $array_of_struct ?? new TypedCDataArray(
            TestType1::newCData(),
            TestType1::class
        );
    }
}
