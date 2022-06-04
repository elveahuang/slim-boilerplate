<?php
declare(strict_types=1);

namespace App\Http\Controllers\Commons;

use App\Core\Exceptions\ServiceException;
use App\Core\Http\EntityController;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use App\Services\UserService;

/**
 * 基础实体控制器
 */
abstract class AbstractEntityController extends EntityController
{

    /**
     * @return UserService|EntityService|Service
     * @throws ServiceException
     */
    protected function getUserService(): UserService|EntityService|Service
    {
        return $this->getService(UserService::class);
    }

}
