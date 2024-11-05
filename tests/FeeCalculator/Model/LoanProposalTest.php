<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\FeeCalculator\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanTerm;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

final class LoanProposalTest extends TestCase
{
    public static function provideProperLoanAmounts(): array
    {
        return [
            [1_000.0],
            [1_000.01],
            [1_234.56],
            [19_999.99],
            [20_000.0],
        ];
    }

    #[DataProvider('provideProperLoanAmounts')]
    public function testShouldProperlyCreateLoanProposalInstance(float $loanAmount): void
    {
        $instance = new LoanProposal(LoanTerm::MOTHNS_12, new Amount($loanAmount));

        self::assertInstanceOf(LoanProposal::class, $instance);
    }

    public static function provideUnsupportedLoanAmounts(): array
    {
        return [
            [999.99],
            [20_000.01],
        ];
    }

    #[DataProvider('provideUnsupportedLoanAmounts')]
    public function testShouldFailWhenUnsupportedLoanAmountGiven(float $loanAmount): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Loan amount must be greater than or equal to 1 000 and lower than or equal to 20 000.');

        new LoanProposal(LoanTerm::MOTHNS_12, new Amount($loanAmount));
    }
}
