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

use Symfony\Component\HttpFoundation\RequestStack;

class RequestChecker implements CheckerInterface
{
    /**
     * Enable reCaptcha
     *
     * @var boolean
     */
    private $enabled;

    /**
     * Recaptcha Private Key
     *
     * @var boolean
     */
    private $secretKey;

    /**
     * Request Stack
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * HTTP Proxy informations
     *
     * @var array
     */
    private $proxy;

    /**
     * Enable serverside host check.
     *
     * @var boolean
     */
    private $verifyHost;

    /**
     * Submit key.
     *
     * @var string
     */
    private $requestedKey;

    /**
     * @var array
     */
    private $errorMessages = [];

    public function __construct(RequestStack $requestStack, $enabled, $secretKey, array $proxy, $verifyHost, $requestedKey)
    {
        $this->enabled = $enabled;
        $this->secretKey = $secretKey;
        $this->requestStack = $requestStack;
        $this->proxy = $proxy;
        $this->verifyHost = $verifyHost;
        $this->requestedKey = $requestedKey;
    }

    /**
     * @param string $code
     *
     * @return void
     */
    private function addErrorMessage($code)
    {
        switch (strtolower($code)) {
            case 'missing-input-secret':
                $this->errorMessages[self::Missing_Input_Secret_Message] = true;
                break;
            case 'invalid-input-secret':
                $this->errorMessages[self::Invalid_Input_Secret_Message] = true;
                break;
            case 'missing-input-response':
                $this->errorMessages[self::Missing_Input_Response_Message] = true;
                break;
            case 'invalid-input-response':
                $this->errorMessages[self::Invalid_Input_Response_Message] = true;
                break;
            case 'bad-request':
                $this->errorMessages[self::Bad_Request_Message] = true;
                break;
            default:
                $this->errorMessages[self::Message] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getErrors()
    {
        return array_keys($this->errorMessages);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        if (!$this->enabled) {
            return true;
        }

        $masterRequest = $this->requestStack->getMasterRequest();
        $remoteIp = $masterRequest->getClientIp();
        $answer = $masterRequest->get($this->requestedKey);

        if (empty($remoteIp)) {
            $this->errorMessages[self::Invalid_Remote_IP_Message] = true;

            return false;
        }

        if (false === $response = $this->checkAnswer($this->secretKey, $remoteIp, $answer)) {
            $this->errorMessages[self::Message] = true;

            return false;
        };

        if (false === $response["success"]) {
            foreach ($response['error-codes'] as $code) {
                $this->addErrorMessage($code);
            }

            return false;
        }

        if ($this->verifyHost && $response["hostname"] !== $masterRequest->getHost()) {
            $this->errorMessages[self::Invalid_Host_Message] = true;

            return false;
        }

        return true;
    }

    /**
     * @param string $secretKey
     * @param string $remoteip
     * @param string $answer
     *
     * @return boolean
     */
    private function checkAnswer($secretKey, $remoteIp, $answer)
    {
        if ($answer == null || strlen($answer) == 0) {
            return false;
        }

        return json_decode($this->httpGet([
            "secret" => $secretKey,
            "remoteip" => $remoteIp,
            "response" => $answer
        ]), true);
    }

    /**
     * Submits an HTTP POST to a reCAPTCHA server.
     *
     * @param array $data
     *
     * @return string response
     */
    private function httpGet($data)
    {
        return file_get_contents(sprintf(
            "https://www.google.com/recaptcha/api/siteverify?%s", http_build_query($data, '', "&")
        ), false, $this->getResourceContext());
    }

    /**
     * Resource context.
     *
     * @return resource context for HTTP Proxy.
     */
    private function getResourceContext()
    {
        if (null === $this->proxy["host"] || null === $this->proxy["port"]) {
            return null;
        }

        $options = array();
        foreach (array("http", "https") as $protocol) {
            $options[$protocol] = array(
                "method" => "GET",
                "proxy" => sprintf("tcp://%s:%s", $this->proxy["host"], $this->proxy["port"]),
                "request_fulluri" => true
            );

            if (null !== $this->proxy["auth"]) {
                $options[$protocol]["header"] = sprintf("Proxy-Authorization: Basic %s", base64_encode($this->proxy["auth"]));
            }
        }

        return stream_context_create($options);
    }
}

