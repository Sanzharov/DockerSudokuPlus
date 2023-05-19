<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\SudokuPlusValidator;
use ReflectionClass;

class SudokuPlusValidatorTest extends TestCase
{
    /**
     * @var SudokuPlusValidator
     */
    private static $sudokuValidator;

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$sudokuValidator = new SudokuPlusValidator();
    }

    /**
     * @dataProvider gridSizeProvider
     */
    public function testValidateGridSize($grid, $expectedResult)
    {
        $method = (new ReflectionClass(SudokuPlusValidator::class))->getMethod('validateGridSize');
        $method->setAccessible(true);

        $this->assertSame($expectedResult, $method->invokeArgs(self::$sudokuValidator, [$grid]));
    }

    /**
     * @dataProvider gridContentProvider
     */
    public function testValidateGridContent($grid, $expectedResult)
    {
        $method = (new ReflectionClass(SudokuPlusValidator::class))->getMethod('validateGridContent');
        $method->setAccessible(true);

        $this->assertSame($expectedResult, $method->invokeArgs(self::$sudokuValidator, [$grid]));
    }

    /**
     * @dataProvider gridRegionsProvider
     */
    public function testValidateRegions($grid, $expectedResult)
    {
        $method = (new ReflectionClass(SudokuPlusValidator::class))->getMethod('validateRegions');
        $method->setAccessible(true);

        $this->assertSame($expectedResult, $method->invokeArgs(self::$sudokuValidator, [$grid]));
    }

    /**
     * @return array[]
     */
    public static function gridSizeProvider(): array
    {
        return [
            [[[1, 2, 3], [4, 5, 6], [7, 8, 9]], true], // 3x3, valid
            [[[1, 2, 3], [4, 5, 6]], false],        // not square, invalid
            [[[1, 2], [3, 4], [5, 6]], false]       // not square, invalid
        ];
    }

    /**
     * @return array[]
     */
    public static function gridContentProvider(): array
    {
        return [
            [[[1, 2, 3, 4], [3, 4, 1, 2], [2, 1, 4, 3], [4, 3, 2, 1]], true], // valid contents
            [[[1, 2, 3], [4, 5, 'a'], [7, 8, 9]], false], // invalid contents (non-numeric)
            [[[1, 2, 3], [4, 5, 6], [7, 8, 10]], false]   // invalid contents (out of range)
        ];
    }

    /**
     * @return array[]
     */
    public static function gridRegionsProvider(): array
    {
        return [
            [[
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                [5, 6, 7, 8, 1, 2, 3, 4, 13, 14, 15, 16, 9, 10, 11, 12],
                [9, 10, 11, 12, 13, 14, 15, 16, 1, 2, 3, 4, 5, 6, 7, 8],
                [13, 14, 15, 16, 9, 10, 11, 12, 5, 6, 7, 8, 1, 2, 3, 4],
                [2, 1, 4, 3, 6, 5, 8, 7, 10, 9, 12, 11, 14, 13, 16, 15],
                [6, 5, 8, 7, 2, 1, 4, 3, 14, 13, 16, 15, 10, 9, 12, 11],
                [10, 9, 12, 11, 14, 13, 16, 15, 2, 1, 4, 3, 6, 5, 8, 7],
                [14, 13, 16, 15, 10, 9, 12, 11, 6, 5, 8, 7, 2, 1, 4, 3],
                [3, 4, 1, 2, 7, 8, 5, 6, 11, 12, 9, 10, 15, 16, 13, 14],
                [7, 8, 5, 6, 3, 4, 1, 2, 15, 16, 13, 14, 11, 12, 9, 10],
                [11, 12, 9, 10, 15, 16, 13, 14, 3, 4, 1, 2, 7, 8, 5, 6],
                [15, 16, 13, 14, 11, 12, 9, 10, 7, 8, 5, 6, 3, 4, 1, 2],
                [4, 3, 2, 1, 8, 7, 6, 5, 12, 11, 10, 9, 16, 15, 14, 13],
                [8, 7, 6, 5, 4, 3, 2, 1, 16, 15, 14, 13, 12, 11, 10, 9],
                [12, 11, 10, 9, 16, 15, 14, 13, 4, 3, 2, 1, 8, 7, 6, 5],
                [16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]
            ], true], // valid
            [[[1, 2, 3, 4], [3, 4, 1, 2], [2, 1, 4, 3], [4, 3, 2, 1]], true], // valid
            [[[1, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                [5, 6, 7, 8, 1, 2, 3, 4, 13, 14, 15, 16, 9, 10, 11, 12],
                [9, 10, 11, 12, 13, 14, 15, 16, 1, 2, 3, 4, 5, 6, 7, 8],
                [13, 14, 15, 16, 9, 10, 11, 12, 5, 6, 7, 8, 1, 2, 3, 4],
                [2, 1, 4, 3, 6, 5, 8, 7, 10, 9, 12, 11, 14, 13, 16, 15],
                [6, 5, 8, 7, 2, 1, 4, 3, 14, 13, 16, 15, 10, 9, 12, 11],
                [10, 9, 12, 11, 14, 13, 16, 15, 2, 1, 4, 3, 6, 5, 8, 7],
                [14, 13, 16, 15, 10, 9, 12, 11, 6, 5, 8, 7, 2, 1, 4, 3],
                [3, 4, 1, 2, 7, 8, 5, 6, 11, 12, 9, 10, 15, 16, 13, 14],
                [7, 8, 5, 6, 3, 4, 1, 2, 15, 16, 13, 14, 11, 12, 9, 10],
                [11, 12, 9, 10, 15, 16, 13, 14, 3, 4, 1, 2, 7, 8, 5, 6],
                [15, 16, 13, 14, 11, 12, 9, 10, 7, 8, 5, 6, 3, 4, 1, 2],
                [4, 3, 2, 1, 8, 7, 6, 5, 12, 11, 10, 9, 16, 15, 14, 13],
                [8, 7, 6, 5, 4, 3, 2, 1, 16, 15, 14, 13, 12, 11, 10, 9],
                [12, 11, 10, 9, 16, 15, 14, 13, 4, 3, 2, 1, 8, 7, 6, 5],
                [16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1]], false] // invalid
        ];
    }

    /**
     * @return void
     */
    public function testValidateSudokuWithValidGrid(): void
    {
        $csvText = "1,2,3,4\n3,4,1,2\n2,1,4,3\n4,3,2,1";

        $validator = new SudokuPlusValidator();
        $result = $validator->validateSudoku($csvText);

        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testValidateSudokuWithInvalidGrid(): void
    {
        $csvText = "1,2,3\n4,5,6\n7,8,9";

        $validator = new SudokuPlusValidator();
        $result = $validator->validateSudoku($csvText);

        $this->assertFalse($result);
    }
}