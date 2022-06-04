<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\EntityService;
use App\Models\Authority;
use App\Repositories\AuthorityRepository;
use App\Repositories\RoleAuthorityRepository;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<Authority, AuthorityRepository>
 */
class AuthorityService extends EntityService
{

    /**
     * @var AuthorityRepository
     */
    protected AuthorityRepository $authorityRepository;

    /**
     * @var RoleAuthorityRepository
     */
    protected RoleAuthorityRepository $roleAuthorityRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param AuthorityRepository $authorityRepository
     * @param RoleAuthorityRepository $roleAuthorityRepository
     */
    #[Pure] public function __construct(
        Container               $container,
        Logger                  $logger,
        Translator              $translator,
        AuthorityRepository     $authorityRepository,
        RoleAuthorityRepository $roleAuthorityRepository
    )
    {
        parent::__construct($container, $logger, $translator);

        $this->authorityRepository = $authorityRepository;
        $this->roleAuthorityRepository = $roleAuthorityRepository;
    }

    /**
     * @return EntityRepository|AuthorityRepository
     */
    protected function getRepository(): EntityRepository|AuthorityRepository
    {
        return $this->authorityRepository;
    }

}
