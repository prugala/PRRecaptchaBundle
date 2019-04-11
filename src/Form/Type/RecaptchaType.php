<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\Form\Type;

use PR\Bundle\RecaptchaBundle\Validator\Constraints\ContainsRecaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'form.recaptcha.label',
            'mapped' => false,
            'constraints' => [
                new ContainsRecaptcha()
            ],
            'validation_groups' => ['Default']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return HiddenType::class;
    }
}
