<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Exceptions\ServiceException;
use App\Http\Controllers\Commons\AbstractEntityController;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * 用户管理控制器
 */
class UserMgrController extends AbstractEntityController
{

    /**
     * @return UserService
     * @throws ServiceException
     */
    protected function getEntityService(): UserService
    {
        return $this->getUserService();
    }

    /**
     * @param Request $request
     * @return Builder
     * @throws ServiceException
     */
    protected function createSearchBuilder(Request $request): Builder
    {
        $params = $request->getParsedBody();
        $builder = $this->getEntityService()->newQuery()->orderBy('id');
        if (isset($params['active']) && strlen($params['active']) > 0) {
            $builder->where('active', $params['active']);
        } else {
            $builder->where('active', 1);
        }
        return $builder;
    }

}
