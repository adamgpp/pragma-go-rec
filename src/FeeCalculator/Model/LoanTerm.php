<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\FeeCalculator\Model;

enum LoanTerm: int
{
    case MOTHNS_12 = 12;
    case MOTHNS_24 = 24;
}
