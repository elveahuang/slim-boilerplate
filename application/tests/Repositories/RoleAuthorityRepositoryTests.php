<?php

namespace tests\Repositories;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use App\Repositories\RoleAuthorityRepository;
use tests\TestCase;

class RoleAuthorityRepositoryTests extends TestCase
{

    /**
     * @return EntityRepository|RoleAuthorityRepository
     * @throws ServiceException
     */
    protected function getUserRepository(): EntityRepository|RoleAuthorityRepository
    {
        return $this->getRepository(RoleAuthorityRepository::class);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindAuthorityIdByRoleIds(): void
    {
        $entity = $this->getUserRepository()->findAuthorityIdByRoleIds([1]);
        $this->assertNotNull($entity);
    }

}
