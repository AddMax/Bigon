# PhpMobReCaptchaBundle

PhpMobReCaptchaBundle is a spam protection using google reCaptcha.


## Installing

Installing via `composer` is recommended.

```yaml
"require": {
  "phpmob/recaptcha-bundle": "~1.1"
}
```

## Enabling

And then enable bundle in `AppKernel.php`

```php
public function registerBundles()
{
    $bundles = [
        ...
        new \PhpMob\ReCaptchaBundle\PhpMobReCaptchaBundle(),
    ];
}
```

## Usage

In order to using it you need to setup a bit, First create google recatpcha via [https://www.google.com/recaptcha/admin](https://www.google.com/recaptcha/admin)
and then config in your symfony app.

1. Configuration
```yaml
phpmob_recaptcha
    site_key: <google_recaptcha_site_key>
    secret_key: <google_recaptcha_secret_key>
    # optional
    enabled: true/false # toggle enable or disable to using it
    verify_host: true/false # strict verify hostname (not allow to submit from remote host)
    theme: light/dark # default light
```

2. Using
```php
<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PhpMob\ReCaptchaBundle\Form\Type\RecaptchaType;
use PhpMob\ReCaptchaBundle\Validator\Constraints\IsValid;

class YourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field', TextType::class, [])

            ->add("recaptcha", RecaptchaType::class, [
                'mapped' => false,
                'label' => false,
                "constraints" => [
                    new IsValid(['groups' => ['some_group_if_need']])
                ]
            ])
        ;
    }
}

```

2.1 Use with Login Form
```yaml
phpmob_recaptcha
    login:
        enabled: true
        firewall: your_firewall_section_name
```

```php
<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use PhpMob\ReCaptchaBundle\Form\Type\RecaptchaType;
use PhpMob\ReCaptchaBundle\Validator\Constraints\IsValid;

class UserLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [])
            ->add('_password', PasswordType::class, [])

            ->add("recaptcha", RecaptchaType::class, [
                'mapped' => false,
                'label' => false,
            ])
        ;
    }
}

```

That was it!

## License

[MIT](/LICENSE)
