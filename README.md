# RecaptchaBundle
Recaptcha v3 bundle for Symfony

[![Latest Stable Version](https://poser.pugx.org/prugala/recaptcha-bundle/v/stable)](https://packagist.org/packages/prugala/recaptcha-bundle)
[![Total Downloads](https://poser.pugx.org/prugala/recaptcha-bundle/downloads)](https://packagist.org/packages/prugala/recaptcha-bundle)
[![License](https://poser.pugx.org/prugala/recaptcha-bundle/license)](https://github.com/prugala/PRRecaptchaBundle/blob/master/LICENSE)

[![Build Status](https://travis-ci.org/prugala/PRRecaptchaBundle.svg?branch=master)](https://travis-ci.org/prugala/PRRecaptchaBundle)

#### Installation
`composer require prugala/recaptcha-bundle`

Register bundle in `AppKernel.php` file:

```new PR\Bundle\RecaptchaBundle\PRRecaptchaBundle()```

#### Configuration
``` yaml
pr_recaptcha:
    public_key: 'public key'
    secret_key: 'secret key'
    enabled: false # optional / default value: true - you can disable it for local or test env
    score_threshhold: 'score' # optional / default value: 0.5
    hide_badge: true # optional / default value: false *
    host: 'www.google.com' # optional / default value: www.google.com **
```
`*` When you hide badge inform visitors that reCAPTCHA is implemented on website:
https://developers.google.com/recaptcha/docs/faq#hiding-badge

`**` If you plan to use reCAPTCHA globally please use host `www.recaptcha.net`. 
More informations:
https://developers.google.com/recaptcha/docs/faq#can-i-use-recaptcha-globally

In Symfony 4.4 and newer you need to register form theme by yourself by adding in `config/packages.twig.yaml`
``` yaml
twig:
    form_themes: ['@PRRecaptcha/Form/recaptcha.html.twig']
```
        
#### How to use
Add field with type `RecaptchaType` to your form, example:

`->add('captcha', RecaptchaType::class)`

Options available: 

``` php
->add('captcha', RecaptchaType::class, [
    'script_nonce_csp' => $nonce,
    'action_name' => 'contact_form'
])
```

- script_nonce_csp: Nonce for Content-Security-Policy header
- action_name: Form specific action name

#### TODO
1. Support for version v2
2. Waiting for suggestions :)
