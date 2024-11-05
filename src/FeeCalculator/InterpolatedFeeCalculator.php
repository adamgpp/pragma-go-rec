<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator;

use PragmaGoTech\Interview\FeeCalculator\FeeCalculatorInterface;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Provider\FeeStructureProviderInterface;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class InterpolatedFeeCalculator implements FeeCalculatorInterface
{
    public function __construct(private readonly FeeStructureProviderInterface $feeStructureProvider)
    {

    }

    public function calculate(LoanProposal $loanProposal): Amount
    {
        $feeStructure = $this->feeStructureProvider->getStructure($loanProposal->term);
        /** @var array<float> $loanAmounts */
        $loanAmounts = array_keys($feeStructure);
        sort($loanAmounts, SORT_NUMERIC);
        $loanAmount = $loanProposal->amount->value;

        foreach ($loanAmounts as $i => $lowerLoanAmount) {
            if ($this->floatsAreEqual($loanAmount, $lowerLoanAmount)) {
                return new Amount($feeStructure[$lowerLoanAmount]);
            }

            $upperLoanAmount = $loanAmounts[$i + 1] ?? 0.0;
            if ($loanAmount > $lowerLoanAmount && $loanAmount < $upperLoanAmount) {
                $feeLower = $feeStructure[$lowerLoanAmount];
                $feeUpper = $feeStructure[$upperLoanAmount];
                $interpolatedFee = $feeLower + ($feeUpper - $feeLower) * (($loanAmount - $lowerLoanAmount) / ($upperLoanAmount - $lowerLoanAmount));

                return new Amount($interpolatedFee);
            }
        }

        // There is no relevant structure for given loan amount.
        throw new \OutOfBoundsException('Can\'t calculate fee for given loan amount.');
    }

    private function floatsAreEqual(float $float1, float $float2): bool
    {
        return 0 === bccomp((string) $float1, (string) $float2, 2);
    }
}
