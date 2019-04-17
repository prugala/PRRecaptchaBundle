# RecaptchaBundle
Recaptcha v3 bundle for Symfony

#### Instalation
`composer require prugala/recaptcha-bundle`

#### Configuration
```
pr_recaptcha:
    public_key: 'public key'
    secret_key: 'secret key'
    score_threshhold: 'score' # optional / default vaule: 0.5
    hide_badge: true # optional / default valuse: false *
```
* When you hide badge inform visitors that reCAPTCHA is implemented on website:
https://developers.google.com/recaptcha/docs/faq#hiding-badge

        
#### How to use
Add field `recaptcha` with type `RecaptchaType` to your form.

`->add('recaptcha', RecaptchaType::class)`

#### TODO
1. More configuration options like a `option to hide badge` and more...
2. Support for version v2
3. Tests
