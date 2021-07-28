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

namespace PhpMob\ReCaptchaBundle\Checker;

interface CheckerInterface
{
    /**
     * The reCAPTCHA validation message
     */
    const Message = 'phpmob.ui.invalid_recaptcha';
    const Missing_Input_Secret_Message = 'phpmob.ui.the_secret_parameter_is_missing';
    const Invalid_Input_Secret_Message = 'phpmob.ui.the_secret_parameter_is_invalid_or_malformed';
    const Missing_Input_Response_Message = 'phpmob.ui.the_response_parameter_is_missing';
    const Invalid_Input_Response_Message = 'phpmob.ui.the_response_parameter_is_invalid_or_malformed';
    const Bad_Request_Message = 'phpmob.ui.the_request_is_invalid_or_malformed';
    const Invalid_Host_Message = "phpmob.ui.invalid_host";
    const Invalid_Remote_IP_Message = "phpmob.ui.invalid_remote_ip";

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return bool
     */
    public function isValid();
}
