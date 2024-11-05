<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class AmountTest extends TestCase
{
    public static function provideProperValues(): array
    {
        return [
            [0, 0.0],
            [0.0, 0.0],
            [0.001, 0.0],
            [0.009, 0.01],
            [0.01, 0.01],
            [1, 1.0],
        ];
    }

    #[DataProvider('provideProperValues')]
    public function testShouldSetProperValue(float $givenValue, float $expectedValue): void
    {
        $instance = new Amount($givenValue);

        self::assertSame($expectedValue, $instance->value);
    }

    public function testShouldFailWhenInvalidValueGiven(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value must be greater than or equalto 0.');

        new Amount(-0.01);
    }
}
