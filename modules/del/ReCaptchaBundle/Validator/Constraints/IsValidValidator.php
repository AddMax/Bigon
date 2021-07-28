<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\ReCaptchaBundle\Validator\Constraints;

use PhpMob\ReCaptchaBundle\Checker\CheckerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidValidator extends ConstraintValidator
{
    /**
     * @var CheckerInterface
     */
    protected $checker;

    public function __construct(CheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     * @param mixed $value
     * @param Constraint|IsValid $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->checker->isValid()) {
            return;
        }

        foreach ($this->checker->getErrors() as $error) {
            $this->context->addViolation($constraint->getErrorMessage($error));
        }
    }
}
