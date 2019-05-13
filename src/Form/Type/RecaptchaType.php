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
    /** @var int */
    private $version;

    /** @var string */
    private $publicKey;

    /** @var bool */
    private $hideBadge;

    /** @var string */
    private $host;

    /**
     * RecaptchaType constructor.
     * @param int $version
     * @param string $publicKey
     * @param bool $hideBadge
     * @param string $host
     */
    public function __construct(
        int $version,
        string $publicKey,
        bool $hideBadge,
        string $host
    ) {
        $this->version = $version;
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
            'pr_recaptcha_version' => $this->version,
            'pr_recaptcha_public_key' => $this->publicKey,
            'pr_recaptcha_hide_badge' => $this->hideBadge,
            'pr_recaptcha_host' => $this->host
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
            'validation_groups' => [ 'Default' ]
        ]);
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
