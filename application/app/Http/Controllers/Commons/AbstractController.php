<?php
declare(strict_types=1);

namespace App\Http\Controllers\Commons;

use App\Core\Exceptions\ServiceException;
use App\Core\Http\Controller;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use App\Services\UserService;

/**
 * 基础控制器
 */
abstract class AbstractController extends Controller
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
