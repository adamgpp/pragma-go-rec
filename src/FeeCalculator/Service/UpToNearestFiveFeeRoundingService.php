<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Service;

use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class UpToNearestFiveFeeRoundingService implements FeeRoundingServiceInterface
{
    public function roundFee(Amount $loanAmount, Amount $rawFee): Amount
    {
        $total = $loanAmount->value + $rawFee->value;
        $roundedTotal = ceil($total / 5) * 5;

        return new Amount($roundedTotal - $loanAmount->value);
    }
}
