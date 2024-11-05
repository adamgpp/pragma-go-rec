<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Model;

use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

/**
 * A cut down version of a loan application containing
 * only the required properties for this test.
 */
final class LoanProposal
{
    public function __construct(public readonly LoanTerm $term, public readonly Amount $amount)
    {
        if ($amount->value < 1_000.0 || $amount->value > 20_000.0) {
            throw new \InvalidArgumentException('Loan amount must be greater than or equal to 1 000 and lower than or equal to 20 000.');
        }
    }
}
