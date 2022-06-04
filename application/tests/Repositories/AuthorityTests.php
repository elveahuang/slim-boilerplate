<?php

namespace tests\Repositories;

use App\Core\Exceptions\ServiceException;
use App\Repositories\AuthorityRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use tests\TestCase;

class AuthorityTests extends TestCase
{

    /**
     * @return AuthorityRepository
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    protected function getAuthorityRepository(): AuthorityRepository
    {
        return $this->getAppInstance()->getContainer()->get(AuthorityRepository::class);
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ServiceException
     */
    public function testFindById()
    {
        $list = $this->getAuthorityRepository()->findAll();
        $this->assertNotNull($list);
    }

}
