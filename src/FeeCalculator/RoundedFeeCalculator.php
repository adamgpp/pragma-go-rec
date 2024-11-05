<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator;

use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Service\FeeRoundingServiceInterface;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class RoundedFeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private readonly FeeCalculatorInterface $interpolatedFeeCalculator,
        private readonly FeeRoundingServiceInterface $roundingService
    ) {
    }

    public function calculate(LoanProposal $application): Amount
    {
        $interpolatedFee = $this->interpolatedFeeCalculator->calculate($application);

        return $this->roundingService->roundFee($application->amount, $interpolatedFee);
    }
}
