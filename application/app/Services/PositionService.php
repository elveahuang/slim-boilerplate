<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityService;
use App\Models\Position;
use App\Repositories\EntityRelationRepository;
use App\Repositories\PositionRepository;
use App\Repositories\RoleRepository;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<Position, PositionRepository>
 */
class PositionService extends EntityService
{

    /**
     * @var EntityRelationRepository
     */
    protected EntityRelationRepository $entityRelationRepository;

    /**
     * @var PositionRepository
     */
    protected PositionRepository $positionRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param EntityRelationRepository $entityRelationRepository
     * @param PositionRepository $positionRepository
     */
    #[Pure]
    public function __construct(Container                $container,
                                Logger                   $logger,
                                Translator               $translator,
                                EntityRelationRepository $entityRelationRepository,
                                PositionRepository       $positionRepository
    )
    {
        parent::__construct($container, $logger, $translator);

        $this->entityRelationRepository = $entityRelationRepository;
        $this->positionRepository = $positionRepository;
    }

    public function getRepositoryClass(): string
    {
        return RoleRepository::class;
    }

}
