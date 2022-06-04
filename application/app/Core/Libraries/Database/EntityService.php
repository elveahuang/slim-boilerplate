<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use App\Core\Exceptions\ServiceException;
use App\Core\Services\Service;
use App\Core\Types\Page;
use App\Core\Types\Paginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * 实体基础服务
 *
 * @template T
 * @template R
 */
abstract class EntityService extends Service
{

    /**
     * @return R
     * @throws ServiceException
     */
    protected abstract function getRepository(): EntityRepository;

    /**
     * @param int $id
     * @return T
     * @throws ServiceException
     */
    public function findById(int $id): object
    {
        return $this->getRepository()->findById($id);
    }

    /**
     * @return list<T>
     * @throws ServiceException
     */
    public function findAll(): array
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param Builder|null $builder
     * @param Paginator|null $paginator
     * @return Page
     * @throws ServiceException
     */
    public function findByPage(Paginator|null $paginator = null, Builder|null $builder = null): Page
    {
        return $this->getRepository()->findByPage($paginator, $builder);
    }

    /**
     * @param object $entity
     * @return T
     * @throws ServiceException
     */
    public function save(object $entity): object
    {
        $this->getRepository()->save($entity);
        return $entity;
    }

}
