<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Service;

use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

interface FeeRoundingServiceInterface
{
    public function roundFee(Amount $amount, Amount $rawFee): Amount;
}
