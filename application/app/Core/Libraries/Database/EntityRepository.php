<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use App\Core\Types\Page;
use App\Core\Types\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;

/**
 * EntityRepository
 *
 * @template T
 */
abstract class EntityRepository
{

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @param Container $container
     * @param Logger $logger
     */
    public function __construct(Container $container, Logger $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
    }

    /**
     * @return Model|IdModel
     */
    public abstract function getModel(): Model|IdModel;

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return Builder
     */
    public function newModelQuery(): Builder
    {
        return $this->getModel()->newModelQuery();
    }

    /**
     * 获取实体附加信息
     * 可以在子类中重写，用于获取实体其他的信息
     *
     * @param object|null $entity
     */
    protected function getEntityExtra(object|null $entity): void
    {
    }

    /**
     * @param int $id
     * @return T
     */
    public function findById(int $id): object
    {
        $entity = $this->newModelQuery()->find($id);
        $this->getEntityExtra($entity);
        return $entity;
    }

    /**
     * @param array $ids
     * @return Collection<T>
     */
    public function findByIds(array $ids): Collection
    {
        $entity = $this->newModelQuery()->find($ids);
        $this->getEntityExtra($entity);
        return $entity;
    }

    /**
     * 保存或者更新实体
     *
     * @param T $entity
     */
    public function insert(object $entity): object
    {
        $this->getModel()->save($entity);
        return $entity;
    }

    /**
     * @param array $entityList
     * @param int $batchSize
     * @return void
     */
    public function insertBatch(array $entityList, int $batchSize): void
    {

    }

    /**
     * 保存或者更新实体
     *
     * @param T $entity
     */
    public function save(object $entity): void
    {
        $this->getModel()->save($entity);
    }

    /**
     * 删除实体
     *
     * @param T $entity
     */
    public function delete(object $entity): void
    {
        $this->getModel()->delete();
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->deleteByIds([$id]);
    }

    /**
     * @param array $ids
     * @return void
     */
    public function deleteByIds(array $ids): void
    {
        $this->getModel()::destroy($ids);
    }

    /**
     * @return Collection<T>
     */
    public function findAll(): Collection
    {
        return $this->getModel()::all();
    }

    /**
     * @param Builder|null $builder
     * @param Paginator|null $paginator
     * @return Page
     */
    public function findByPage(Paginator $paginator = null, Builder|null $builder = null): Page
    {
        //
        if (is_null($builder)) {
            $builder = $this->newQuery()->orderBy('id');
        }
        //
        if (is_null($paginator)) {
            $paginator = new Paginator();
        }
        // 查询记录，获取总记录数
        $items = ($total = $builder->toBase()->getCountForPagination())
            ? $builder->forPage($paginator->getPage(), $paginator->getLimit())->get($paginator->getColumns()) : [];

        // 计算总页数
        $pages = ceil($total / $paginator->getLimit());

        $page = new Page();
        $page->page = $paginator->getPage();
        $page->limit = $paginator->getLimit();
        $page->total = $total;
        $page->pages = (int)$pages;
        $page->items = $items;
        return $page;
    }

}
