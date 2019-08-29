<?php
declare(strict_types=1);

namespace PR\Tests\Bundle\RecaptchaBundle\Form\Type;

use PR\Bundle\RecaptchaBundle\Form\Type\RecaptchaType;
use PHPUnit\Framework\TestCase;
use PR\Bundle\RecaptchaBundle\Validator\Constraints\ContainsRecaptcha;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class RecaptchaTypeTest extends TestCase
{
    /** @var RecaptchaType */
    private $formType;

    protected function setUp(): void
    {
        $this->formType = new RecaptchaType('publicKey', true, 'www.google.com');
    }

    /**
     * @test
     */
    public function getParent(): void
    {
        $this->assertSame(HiddenType::class, $this->formType->getParent());
    }

    /**
     * @test
     *
     * @throws \ReflectionException
     */
    public function buildView(): void
    {
        $view = new FormView();

        /** @var FormInterface $form */
        $form = $this->createMock(FormInterface::class);

        $this->assertArrayNotHasKey('pr_recaptcha_public_key', $view->vars);
        $this->assertArrayNotHasKey('pr_recaptcha_hide_badge', $view->vars);
        $this->assertArrayNotHasKey('pr_recaptcha_host', $view->vars);

        $this->formType->buildView($view, $form, []);

        $this->assertEquals('publicKey', $view->vars['pr_recaptcha_public_key']);
        $this->assertTrue($view->vars['pr_recaptcha_hide_badge']);
        $this->assertEquals('www.google.com', $view->vars['pr_recaptcha_host']);
    }

    /**
     * @test
     */
    public function configureOptions()
    {
        $optionsResolver = new OptionsResolver();
        $this->formType->configureOptions($optionsResolver);
        $options = $optionsResolver->resolve();

        $expected = [
            'label' => false,
            'mapped' => false,
            'constraints' => [
                new ContainsRecaptcha()
            ],
            'validation_groups' => ['Default'],
            'script_nonce_csp' => ''
        ];

        $this->assertEquals($expected, $options);
    }
}
