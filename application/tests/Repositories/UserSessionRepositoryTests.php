<?php
declare(strict_types=1);

namespace tests\Repositories;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityRepository;
use App\Repositories\UserSessionRepository;
use tests\TestCase;

class UserSessionRepositoryTests extends TestCase
{

    /**
     * @return EntityRepository|UserSessionRepository
     * @throws ServiceException
     */
    protected function getUserSessionRepository(): EntityRepository|UserSessionRepository
    {
        return $this->getRepository(UserSessionRepository::class);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindByPage()
    {
        $page = $this->getUserSessionRepository()->findByPage();
        $this->assertNotNull($page);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testCreate()
    {
        $entity = $this->getUserSessionRepository()->getModel()->fill([
            'user_id' => '111',
            'session_id' => '123',
            'host' => '$request->getUri()->getQuery()'
        ])->save();
        $this->assertNotNull($entity);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindAll()
    {
        $entities = $this->getUserSessionRepository()->findAll();
        $this->assertNotNull($entities);
    }

    /**
     * @return void
     * @throws ServiceException
     */
    public function testFindById()
    {
        $entity = $this->getUserSessionRepository()->findById(1);
        $this->assertNotNull($entity);
    }

}
