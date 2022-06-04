<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\EntityService;
use App\Models\Role;
use App\Repositories\RoleAuthorityRepository;
use App\Repositories\RoleRepository;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<Role, RoleRepository>
 */
class RoleService extends EntityService
{

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * @var RoleAuthorityRepository
     */
    protected RoleAuthorityRepository $roleAuthorityRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param RoleRepository $roleRepository
     * @param RoleAuthorityRepository $roleAuthorityRepository
     */
    #[Pure]
    public function __construct(
        Container               $container,
        Logger                  $logger,
        Translator              $translator,
        RoleRepository          $roleRepository,
        RoleAuthorityRepository $roleAuthorityRepository
    )
    {
        parent::__construct($container, $logger, $translator);

        $this->roleAuthorityRepository = $roleAuthorityRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return EntityRepository|RoleRepository
     */
    protected function getRepository(): EntityRepository|RoleRepository
    {
        return $this->roleRepository;
    }

}
