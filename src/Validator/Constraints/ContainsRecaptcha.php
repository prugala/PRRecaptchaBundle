<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ContainsRecaptcha extends Constraint
{
    public $message = 'This value is not a valid captcha.';
}
