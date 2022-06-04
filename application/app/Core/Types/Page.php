<?php
declare(strict_types=1);

namespace App\Core\Types;

use Illuminate\Database\Eloquent\Collection;

class Page
{
    /**
     * 当前页码
     * @var int
     */
    public int $page = 1;
    /**
     * 每页记录数
     * @var int
     */
    public int $limit = 10;
    /**
     * 总记录数
     * @var int
     */
    public int $total = 0;
    /**
     * 总页数
     * @var int
     */
    public int $pages = 0;
    /**
     * 数据
     * @var Collection|array
     */
    public Collection|array $items = [];
}
