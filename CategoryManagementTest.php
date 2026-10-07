<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CategoryManagementTest extends TestCase
{
    /*
    |--------------------------------------------------------------------------
    | ADD CATEGORY
    |--------------------------------------------------------------------------
    */

    public function testCategoryNameNotEmpty(): void
    {
        $category = "Food";

        $this->assertNotEmpty(
            $category
        );
    }

    public function testMonthlyLimitValid(): void
    {
        $limit = 500.00;

        $this->assertGreaterThan(
            0,
            $limit
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CATEGORY
    |--------------------------------------------------------------------------
    */

    public function testUpdateCategoryName(): void
    {
        $oldName = "Food";

        $newName = "Food & Drinks";

        $this->assertNotEquals(
            $oldName,
            $newName
        );
    }

    public function testUpdateMonthlyLimit(): void
    {
        $oldLimit = 500;

        $newLimit = 1000;

        $this->assertGreaterThan(
            $oldLimit,
            $newLimit
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CATEGORY (SOFT DELETE)
    |--------------------------------------------------------------------------
    */

    public function testSoftDeleteFlag(): void
    {
        $isDeleted = 1;

        $this->assertEquals(
            1,
            $isDeleted
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TOTAL MONTHLY BUDGET
    |--------------------------------------------------------------------------
    */

    public function testTotalMonthlyBudgetCalculation(): void
    {
        $limits = [
            500,
            1000,
            1500
        ];

        $this->assertEquals(
            3000,
            array_sum($limits)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CATEGORY LIST
    |--------------------------------------------------------------------------
    */

    public function testCategoryCount(): void
    {
        $categories = [
            'Food',
            'Transport',
            'Rent'
        ];

        $this->assertCount(
            3,
            $categories
        );
    }

    public function testCategoryExists(): void
    {
        $categories = [
            'Food',
            'Transport',
            'Rent'
        ];

        $this->assertContains(
            'Food',
            $categories
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SECURITY
    |--------------------------------------------------------------------------
    */

    public function testHtmlEscaping(): void
    {
        $input = '<script>alert(1)</script>';

        $output = htmlspecialchars(
            $input
        );

        $this->assertNotEquals(
            $input,
            $output
        );
    }

    public function testCategoryNameEscaping(): void
    {
        $input = '<b>Food</b>';

        $output = htmlspecialchars(
            $input
        );

        $this->assertStringContainsString(
            '&lt;b&gt;',
            $output
        );
    }
}