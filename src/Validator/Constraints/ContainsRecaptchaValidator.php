<?php
declare(strict_types=1);

namespace PR\Bundle\RecaptchaBundle\Validator\Constraints;

use Psr\Log\LoggerInterface;
use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class ContainsRecaptchaValidator extends ConstraintValidator
{
    /** @var string */
    private $secretKey;

    /** @var float */
    private $scoreThreshhold;

    /** @var RequestStack */
    private $requestStack;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ContainsRecaptchaValidator constructor.
     * @param string $secretKey
     * @param float $scoreThreshhold
     * @param RequestStack $requestStack
     * @param LoggerInterface $logger
     */
    public function __construct(string $secretKey, float $scoreThreshhold, RequestStack $requestStack, LoggerInterface $logger)
    {
        $this->secretKey = $secretKey;
        $this->scoreThreshhold = $scoreThreshhold;
        $this->requestStack = $requestStack;
        $this->logger = $logger;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsRecaptcha) {
            throw new UnexpectedTypeException($constraint, ContainsRecaptcha::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!$this->isTokenValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }

    /**
     * @param string $token
     * @return bool
     */
    private function isTokenValid(string $token): bool
    {
        try {
            $remoteIp = $this->requestStack->getCurrentRequest()->getClientIp();

            $recaptcha = new ReCaptcha($this->secretKey);

            $response = $recaptcha
                ->setExpectedAction('form')
                ->setScoreThreshold($this->scoreThreshhold)
                ->verify($token, $remoteIp);

            return $response->isSuccess();
        } catch (\Exception $exception) { // Change on custom Exception
            $this->logger->error(
                'reCAPTCHA validator error: ' . $exception->getMessage(),
                [
                    'exception' => $exception
                ]
            );

            return false;
        }
    }
}
