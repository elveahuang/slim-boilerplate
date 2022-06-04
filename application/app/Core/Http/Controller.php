<?php
declare(strict_types=1);

namespace App\Core\Http;

use App\Core\Context;
use App\Core\Exceptions\ServiceException;
use App\Core\Exceptions\ValidationException;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use Psr\Container\ContainerInterface as Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface as Validator;
use Throwable;

/**
 * Controller
 */
abstract class Controller
{

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var Translator
     */
    protected Translator $translator;

    /**
     * @var Validator
     */
    protected Validator $validator;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param Validator $validator
     */
    public function __construct(Container $container, Logger $logger, Translator $translator, Validator $validator)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->translator = $translator;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return Context
     */
    public function getContext(Request $request): Context
    {
        return $request->getAttribute('context');
    }

    /**
     * @param Request $request
     * @param mixed $value
     * @param Constraint|array|null $constraints
     * @param string|GroupSequence|array|null $groups
     * @return array
     * @throws ValidationException
     */
    public function validate(
        Request                    $request,
        mixed                      $value,
        Constraint|array           $constraints = null,
        string|GroupSequence|array $groups = null
    ): array
    {
        $this->translator->setLocale($this->getContext($request)->locale);

        $errors = [];
        $violations = $this->validator->validate($value, $constraints, $groups);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $property = $violation->getPropertyPath();
                if (strlen($property) > 0 && str_ends_with($property, ']') && str_starts_with($property, '[')) {
                    $property = substr($property, 1, strlen($property) - 2);
                }
                $errors[] = [
                    'property' => $property,
                    'message' => $this->translator->trans($violation->getMessage()),
                ];
            }
            throw new ValidationException($request, $errors);
        }
        return $errors;
    }

    /**
     * @return Translator
     * @throws ServiceException
     */
    public function getTranslator(): Translator
    {
        try {
            return $this->container->get(Translator::class);
        } catch (Throwable $e) {
            $this->logger->error("fail to get Translator instance.", $e->getTrace());
            throw new ServiceException();
        }
    }

    /**
     * @param Request $request
     * @return Translator
     * @throws ServiceException
     */
    public function getRequestTranslator(Request $request): Translator
    {
        $translator = $this->getTranslator();
        $context = $this->getContext($request);
        $translator->setLocale($context->locale);
        return $translator;
    }

    /**
     * @param string $id
     * @return EntityService|Service
     * @throws ServiceException
     */
    protected function getService(string $id): EntityService|Service
    {
        try {
            return $this->container->get($id);
        } catch (Throwable $e) {
            $this->logger->error("fail to get Service instance.", $e->getTrace());
            throw new ServiceException();
        }
    }

}
