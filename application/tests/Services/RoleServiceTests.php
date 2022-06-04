<?php
declare(strict_types=1);

namespace tests\Services;

use App\Core\Exceptions\ServiceException;
use App\Services\RoleService;
use tests\TestCase;
use Throwable;

class RoleServiceTests extends TestCase
{

    /**
     * @return RoleService
     * @throws ServiceException
     */
    protected function getRoleService(): RoleService
    {
        try {
            return $this->getAppInstance()->getContainer()->get(RoleService::class);
        } catch (Throwable $e) {
            throw new ServiceException();
        }
    }

    /**
     * @throws ServiceException
     */
    public function testLogin()
    {
        $entityList = $this->getRoleService()->findAll();
        $this->assertNotNull($entityList);
    }

}
