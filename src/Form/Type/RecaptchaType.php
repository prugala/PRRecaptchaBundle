<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\Form\Type;

use PR\Bundle\RecaptchaBundle\Validator\Constraints\ContainsRecaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaType extends AbstractType
{
    /** @var string */
    private $publicKey;

    /** @var bool */
    private $hideBadge;

    /** @var string */
    private $host;
    /**
     * RecaptchaType constructor.
     *
     * @param string $publicKey
     * @param bool $hideBadge
     * @param string $host
     */
    public function __construct(string $publicKey, bool $hideBadge, string $host)
    {
        $this->publicKey = $publicKey;
        $this->hideBadge = $hideBadge;
        $this->host = $host;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, [
            'pr_recaptcha_public_key' => $this->publicKey,
            'pr_recaptcha_hide_badge' => $this->hideBadge,
            'pr_recaptcha_host' => $this->host,
            'script_nonce_csp' => $options['script_nonce_csp'] ?? ''
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
            'mapped' => false,
            'constraints' => [
                new ContainsRecaptcha()
            ],
            'validation_groups' => [ 'Default' ],
            'script_nonce_csp' => ''
        ]);

        $resolver->setAllowedTypes('script_nonce_csp', 'string');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return HiddenType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pr_recaptcha';
    }

}
