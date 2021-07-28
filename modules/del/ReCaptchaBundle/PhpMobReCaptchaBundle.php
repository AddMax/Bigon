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

namespace PhpMob\ReCaptchaBundle;

use PhpMob\ReCaptchaBundle\DependencyInjection\Compiler\LoginFirewallListenerPass;
use PhpMob\ReCaptchaBundle\DependencyInjection\PhpMobReCaptchaExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobReCaptchaBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new PhpMobReCaptchaExtension();
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new LoginFirewallListenerPass());
    }
}
