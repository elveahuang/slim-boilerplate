<?php
declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;
use Throwable;

/**
 * 顶层服务
 */
abstract class Service
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
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     */
    public function __construct(Container $container, Logger $logger, Translator $translator)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * @param string $id
     * @return EntityRepository
     * @throws ServiceException
     */
    protected function getEntityRepository(string $id): EntityRepository
    {
        try {
            return $this->container->get($id);
        } catch (Throwable $e) {
            $this->logger->error("fail to get EntityRepository instance.", $e->getTrace());
            throw new ServiceException();
        }
    }

}
