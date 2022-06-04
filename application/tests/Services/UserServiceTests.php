<?php
declare(strict_types=1);

namespace tests\Services;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use App\Services\UserService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use tests\TestCase;
use Throwable;

/**
 *
 */
class UserServiceTests extends TestCase
{

    /**
     * @return UserService|EntityService|Service
     * @throws ServiceException
     */
    protected function getUserService(): UserService|EntityService|Service
    {
        try {
            return $this->getService(UserService::class);
        } catch (Throwable $e) {
            throw new ServiceException();
        }
    }

    /**
     * @throws ServiceException
     */
    public function testBase()
    {
        $entityList = $this->getUserService()->findAll();
        $this->assertNotNull($entityList);

        $entity = $this->getUserService()->findById(1);
        $this->assertNotNull($entity);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testLogin()
    {
        $service = $this->getAppInstance()->getContainer()->get(UserService::class);
        $credentials = [
            'grant_type' => 'password',
            'username' => 'admin',
            'password' => 'admin',
        ];
        $result = $service->login($credentials);
        $this->assertNotNull($result);
    }

}
