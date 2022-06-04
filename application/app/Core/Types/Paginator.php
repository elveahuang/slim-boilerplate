<?php
declare(strict_types=1);

namespace App\Core\Types;

class Paginator
{

    /**
     * 当前页码
     * @var int
     */
    private int $page = 1;

    /**
     * 每页记录数
     * @var int
     */
    private int $limit = 10;

    /**
     * 请求参数
     * @var null|array|object
     */
    private null|array|object $params = [];

    /**
     * 结果列
     * @var array
     */
    private array $columns = ['*'];

    /**
     * @param int $page
     * @param int $limit
     * @param array $params
     * @param array $columns
     */
    public function __construct(int $page = 1, int $limit = 12, array $params = [], array $columns = ['*'])
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->params = $params;
        $this->columns = $columns;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return array|object|null
     */
    public function getParams(): object|array|null
    {
        return $this->params;
    }

    /**
     * @param array|object|null $params
     */
    public function setParams(object|array|null $params): void
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

}
