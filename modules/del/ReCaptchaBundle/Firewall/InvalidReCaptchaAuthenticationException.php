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

namespace PhpMob\ReCaptchaBundle\Firewall;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class InvalidReCaptchaAuthenticationException extends AuthenticationException
{
    private $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return array_key_exists(0, $this->errors) ? $this->errors[0] : parent::getMessageKey();
    }

    public function serialize()
    {
        return serialize(array(
            $this->errors,
            $this->code,
            $this->message,
            $this->file,
            $this->line,
        ));
    }

    public function unserialize($str)
    {
        list(
            $this->errors,
            $this->code,
            $this->message,
            $this->file,
            $this->line
            ) = unserialize($str);
    }
}
