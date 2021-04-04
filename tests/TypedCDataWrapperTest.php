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

namespace TypedCData\FFI;

use PHPUnit\Framework\TestCase;
use TypedCData\TestClass\TestType1;
use TypedCData\TestClass\TestType2;
use TypedCData\TypedCDataWrapper;

class TypedCDataWrapperTest extends TestCase
{
    public function testCreateWrapperSingleScalarField()
    {
        $test_class = new class () {
            public function testMethod(TestType1 $test_type_1): void
            {
                $test_type_1->int_field = 123;
            }
        };
        $wrapper_creator = new TypedCDataWrapper();
        $wrapper = $wrapper_creator->createWrapper([$test_class, 'testMethod']);
        $test_type_cdata = TestType1::newCData();
        $wrapper($test_type_cdata);
        $this->assertSame(123, $test_type_cdata->int_field);
    }

    public function testCreateWrapperTypedCDataArray()
    {
        $test_class = new class ($this) {
            private TestCase $test_case;
            public function __construct(TestCase $test_case)
            {
                $this->test_case = $test_case;
            }
            public function testMethod(TestType2 $test_type_2): void
            {
                $this->test_case->assertSame(789, $test_type_2->array_of_struct[0]->int_field);
                $test_type_2->array_of_struct[0]->int_field = 456;
            }
        };
        $wrapper_creator = new TypedCDataWrapper();
        $wrapper = $wrapper_creator->createWrapper([$test_class, 'testMethod']);
        $test_type_cdata = TestType2::newCData();
        $test_type_cdata->array_of_struct[0]->int_field = 789;
        $wrapper($test_type_cdata);
        $this->assertSame(456, $test_type_cdata->array_of_struct[0]->int_field);
    }
}
