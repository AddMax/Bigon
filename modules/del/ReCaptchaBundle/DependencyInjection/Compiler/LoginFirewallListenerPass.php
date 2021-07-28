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

namespace PhpMob\ReCaptchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoginFirewallListenerPass implements CompilerPassInterface
{
    private function getFirewallFactoryKey()
    {
        // Is this should be config?
        return 'form-login';
    }

    private function getFailureHandlerId($id)
    {
        return 'security.authentication.failure_handler.'.$id.'.'.str_replace('-', '_', $this->getFirewallFactoryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('phpmob.recaptcha.login');

        if (!$config['enabled']) {
            return;
        }

        if (empty($config['firewall'])) {
            throw new \RuntimeException("No firewall name provided (`phpmob_recaptcha.login.firewall`).");
        }

        $decoratedId = 'security.authentication.listener.form.' . $config['firewall'];
        $decorated = $container->getDefinition($decoratedId);
        $definition = $container->getDefinition('phpmob.recaptcha.firewall');
        $definition->replaceArgument(0, new Reference($this->getFailureHandlerId($config['firewall'])));
        $definition->replaceArgument(2, new Reference('phpmob.recaptcha.firewall.inner'));
        $definition->replaceArgument(3, $decorated->getArgument(7));
        $definition->setDecoratedService($decoratedId);
        $definition->setAbstract(false);
    }
}
