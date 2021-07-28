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

namespace PhpMob\ReCaptchaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class RecaptchaType extends AbstractType
{
    /**
     * @var string
     */
    private $siteKey;

    /**
     * @var string
     */
    private $theme;

    /**
     * @var string
     */
    private $enabled;

    public function __construct($siteKey, $theme, $enabled = true)
    {
        $this->siteKey = $siteKey;
        $this->theme = $theme;
        $this->enabled = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['site_key'] = $this->siteKey;
        $view->vars['theme'] = $this->theme;
        $view->vars['enabled'] = $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'phpmob_recaptcha';
    }
}
