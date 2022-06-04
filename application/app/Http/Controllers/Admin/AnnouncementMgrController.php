<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Exceptions\ServiceException;
use App\Core\Http\EntityController;
use App\Core\Services\EntityService;
use App\Core\Services\Service;
use App\Services\AnnouncementService;

/**
 * 资讯管理控制器
 */
class AnnouncementMgrController extends EntityController
{

    /**
     * @return AnnouncementService|EntityService|Service
     * @throws ServiceException
     */
    protected function getEntityService(): AnnouncementService|EntityService|Service
    {
        return $this->getService(AnnouncementService::class);
    }

}
