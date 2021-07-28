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

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class IsValid extends Constraint
{
    /**
     * The reCAPTCHA validation message
     */
    public $message = CheckerInterface::Message;
    public $missingInputSecretMessage = CheckerInterface::Missing_Input_Secret_Message;
    public $invalidInputSecretMessage = CheckerInterface::Invalid_Input_Secret_Message;
    public $missingInputResponseMessage = CheckerInterface::Missing_Input_Response_Message;
    public $invalidInputResponseMessage = CheckerInterface::Invalid_Input_Response_Message;
    public $badRequestMessage = CheckerInterface::Bad_Request_Message;
    public $invalidHostMessage = CheckerInterface::Invalid_Host_Message;
    public $invalidRemoteIpMessage = CheckerInterface::Invalid_Remote_IP_Message;

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    /**
     * @param $code
     *
     * @return string
     */
    public function getErrorMessage($code)
    {
        switch ($code) {
            case CheckerInterface::Missing_Input_Secret_Message:
                return $this->missingInputSecretMessage;
            case CheckerInterface::Invalid_Input_Secret_Message:
                return $this->invalidInputSecretMessage;
            case CheckerInterface::Missing_Input_Response_Message:
                return $this->missingInputResponseMessage;
            case CheckerInterface::Invalid_Input_Response_Message:
                return $this->invalidInputResponseMessage;
            case CheckerInterface::Bad_Request_Message:
                return $this->badRequestMessage;
            case CheckerInterface::Invalid_Host_Message:
                return $this->invalidHostMessage;
            case CheckerInterface::Invalid_Remote_IP_Message:
                return $this->invalidRemoteIpMessage;
            default:
                return $this->message;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'phpmob.recaptcha.validator';
    }
}
