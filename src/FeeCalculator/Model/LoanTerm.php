<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Model;

enum LoanTerm: int
{
    case MONTHS_12 = 12;
    case MONTHS_24 = 24;
}
