<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Exceptions\ServiceException;
use App\Core\Http\EntityController;
use App\Core\Services\EntityService;
use App\Core\Services\Service;
use App\Services\TagService;

/**
 * 标签管理控制器
 */
class TagMgrController extends EntityController
{

    /**
     * @return TagService|EntityService|Service
     * @throws ServiceException
     */
    protected function getEntityService(): TagService|EntityService|Service
    {
        return $this->getService(TagService::class);
    }

}
