<?php
declare(strict_types=1);

namespace tests\Repositories;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use App\Repositories\UserRepository;
use tests\TestCase;

class UserRepositoryTests extends TestCase
{

    /**
     * @return EntityRepository|UserRepository
     * @throws ServiceException
     */
    protected function getUserRepository(): EntityRepository|UserRepository
    {
        return $this->getRepository(UserRepository::class);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindByUsername()
    {
        $entity = $this->getUserRepository()->findByUsername('admin');
        $this->assertNotNull($entity);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindAll()
    {
        $list = $this->getUserRepository()->findAll();
        $this->assertNotNull($list);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindById()
    {
        $entity = $this->getUserRepository()->findById(1);
        $this->assertNotNull($entity);
    }

}
