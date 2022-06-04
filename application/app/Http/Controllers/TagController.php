<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Exceptions\ServiceException;
use App\Core\Services\EntityService;
use App\Core\Services\Service;
use App\Http\Controllers\Commons\AbstractController;
use App\Services\TagService;

/**
 * 标签控制器
 */
class TagController extends AbstractController
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
