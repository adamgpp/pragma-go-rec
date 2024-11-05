<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Provider;

use PragmaGoTech\Interview\FeeCalculator\Model\LoanTerm;

interface FeeStructureProviderInterface
{
    /**
     * @return array<float> Loan amount as array key and fee as array value.
     */
    public function getStructure(LoanTerm $term): array;
}
