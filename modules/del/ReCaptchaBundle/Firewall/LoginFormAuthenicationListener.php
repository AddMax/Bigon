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

use PhpMob\ReCaptchaBundle\Checker\CheckerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

final class LoginFormAuthenicationListener implements ListenerInterface
{
    /**
     * @var AuthenticationFailureHandlerInterface
     */
    private $failureHandler;

    /**
     * @var CheckerInterface
     */
    private $checker;

    /**
     * @var ListenerInterface
     */
    private $decoredListener;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $options;

    public function __construct(AuthenticationFailureHandlerInterface $failureHandler, CheckerInterface $checker, ListenerInterface $listener, array $options, LoggerInterface $logger = null)
    {
        $this->failureHandler = $failureHandler;
        $this->checker = $checker;
        $this->decoredListener = $listener;
        $this->options = $options;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function checkReCaptcha(Request $request)
    {
        if ($this->options['post_only'] && !$request->isMethod('POST')) {
            return false;
        }

        if (!$request->request->has($this->options['username_parameter']) || !$request->request->has($this->options['password_parameter'])) {
            return false;
        }

        if (!$this->checker->isValid()) {
            $exception = new InvalidReCaptchaAuthenticationException('Invalid ReCaptch.');
            $exception->setErrors($this->checker->getErrors());

            throw $exception;
        }
    }

    /**
     * @param Request $request
     * @param AuthenticationException $failed
     *
     * @return Response
     */
    private function onFailure(Request $request, AuthenticationException $failed)
    {
        if (null !== $this->logger) {
            $this->logger->info('Authentication request failed.', array('exception' => $failed));
        }

        $response = $this->failureHandler->onAuthenticationFailure($request, $failed);

        if (!$response instanceof Response) {
            throw new \RuntimeException('Authentication Failure Handler did not return a Response.');
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(GetResponseEvent $event)
    {
        try {
            $this->checkReCaptcha($event->getRequest());
        } catch (InvalidReCaptchaAuthenticationException $e) {
            $event->setResponse($this->onFailure($event->getRequest(), $e));

            return;
        }

        $this->decoredListener->handle($event);
    }
}
