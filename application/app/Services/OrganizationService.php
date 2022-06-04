<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityService;
use App\Models\Organization;
use App\Repositories\EntityRelationRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\RoleRepository;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<Organization, OrganizationRepository>
 */
class OrganizationService extends EntityService
{

    /**
     * @var EntityRelationRepository
     */
    protected EntityRelationRepository $entityRelationRepository;

    /**
     * @var OrganizationRepository
     */
    protected OrganizationRepository $organizationRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param EntityRelationRepository $entityRelationRepository
     * @param OrganizationRepository $organizationRepository
     */
    #[Pure]
    public function __construct(Container                $container,
                                Logger                   $logger,
                                Translator               $translator,
                                EntityRelationRepository $entityRelationRepository,
                                OrganizationRepository   $organizationRepository
    )
    {
        parent::__construct($container, $logger, $translator);

        $this->entityRelationRepository = $entityRelationRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function getRepositoryClass(): string
    {
        return RoleRepository::class;
    }

}
