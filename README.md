PragmaGO.TECH Interview Test - Fee Calculation
=====

## Background

This test is designed to evaluate your problem solving approach and your engineering ability. Design your solution in a way that shows your knowledge of OOP concepts, SOLID principles, design patterns, clean and extensible architecture.

Provide a test suite verifying your solution, use any testing framework you feel comfortable with. Use any libraries (or none) you feel add value to your solution. Treat the packaged project as a template; if you feel that your solution can be improved with modifications to it then please go ahead.

## The test

The requirement is to build a fee calculator that - given a monetary **amount** and a **term** (the contractual duration of the loan, expressed as a number of months) - will produce an appropriate fee for a loan, based on a fee structure and a set of rules described below. A general contract for this functionality is defined in the interface `FeeCalculator`.

Implement your solution such that it fulfils the requirements.

- The fee structure does not follow a formula.
- Values in between the breakpoints should be interpolated linearly between the lower bound and upper bound that they fall between.
- The number of breakpoints, their values, or storage might change.
- The term can be either 12 or 24 (number of months), you can also assume values will always be within this set.
- The fee should be rounded up such that fee + loan amount is an exact multiple of 5.
- The minimum amount for a loan is 1,000 PLN, and the maximum is 20,000 PLN.
- You can assume values will always be within this range but they may be any value up to 2 decimal places.

Example inputs/outputs:
|Loan amount  |Term       |Fee     |
|-------------|-----------|--------|
|11,500 PLN   |24 months  |460 PLN |
|19,250 PLN   |12 months  |385 PLN |

# Installation
A database or any other external dependency is not required for this test.

```bash
composer install
```

# Example

```php
<?php

use PragmaGoTech\Interview\FeeCalculator\Model\LoanProposal;
use PragmaGoTech\Interview\FeeCalculator\Factory\RoundedFeeCalculatorFactory;
use PragmaGoTech\Interview\FeeCalculator\Model\LoanTerm;
use PragmaGoTech\Interview\FeeCalculator\ValueObject\Amount;

$calculator = RoundedFeeCalculatorFactory::create();

$application = new LoanProposal(LoanTerm::MONTHS_24, new Amount(2750));
$fee = $calculator->calculate($application)->value;
// $fee = (float) 115.0
```