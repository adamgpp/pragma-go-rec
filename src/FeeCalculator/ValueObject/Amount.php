<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\ValueObject;

final class Amount
{
    public readonly float $value;

    public function __construct(float $value)
    {
        if (0 > $value) {
            throw new \InvalidArgumentException('Value must be greater than or equal to 0.');
        }

        $this->value = (float) number_format($value, 2, '.', '');
    }
}
