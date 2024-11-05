<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator;

use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

interface FeeCalculatorInterface
{
    /**
     * @return Amount The calculated total fee.
     */
    public function calculate(LoanProposal $application): Amount;
}
