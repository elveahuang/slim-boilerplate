<?php
declare(strict_types=1);

namespace App\Core\Http;

use App\Core\Exceptions\ServiceException;
use App\Core\Libraries\Database\EntityService;
use App\Core\Services\Service;
use App\Core\Utils\WebUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * EntityController
 *
 * @template T
 */
abstract class EntityController extends Controller
{

    /**
     * 实体服务
     *
     * @return EntityService|Service
     */
    protected abstract function getEntityService(): EntityService|Service;

    /**
     * 搜索实体
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ServiceException
     */
    public function search(Request $request, Response $response, array $args): Response
    {
        $data = $this->getEntityService()->findByPage(
            $this->createSearchBuilder($request), WebUtils::getPaginator($request)
        );
        return WebUtils::success($response, $data);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function createSearchBuilder(Request $request): array
    {
        return [];
    }

    /**
     * 查看实体
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws ServiceException
     */
    public function view(Request $request, Response $response, array $args): Response
    {
        if (isset($args['id'])) {
            $id = (int)$args['id'];
            $data = $this->getEntityService()->findById($id, $request);
            return WebUtils::success($response, $data);
        } else {
            return WebUtils::error($response);
        }
    }

    /**
     * 保存实体
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function save(Request $request, Response $response, array $args): Response
    {
        $this->getEntityService()->save($request->getParsedBody());
        return WebUtils::success($response);
    }

    /**
     * 删除实体
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        if (isset($args['id'])) {
            $id = (int)$args['id'];
            $this->logger->log("delete entity {}", $id);
            $this->getEntityService()->delete($id, $request);
            return WebUtils::success($response);
        } else {
            return WebUtils::error($response);
        }
    }

}
