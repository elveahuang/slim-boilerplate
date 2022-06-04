<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Exceptions\ServiceException;
use App\Core\Http\EntityController;
use App\Core\Services\EntityService;
use App\Core\Services\Service;
use App\Services\PosterService;

/**
 * 宣传栏管理控制器
 */
class PosterMgrController extends EntityController
{

    /**
     * @return PosterService|EntityService|Service
     * @throws ServiceException
     */
    protected function getEntityService(): PosterService|EntityService|Service
    {
        return $this->getService(PosterService::class);
    }

}
