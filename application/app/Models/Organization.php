<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id ID
 * @property string|null $code 用户名
 * @property string|null $label 邮箱
 * @property string|null $title 邮箱
 * @property string|null $description 备注
 * @property boolean $root_ind 是否顶层
 * @property boolean $default_ind 是否默认
 * @property int $source 数据来源
 * @property int $active 启用状态
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @property DateTime|string|null $last_modified_at 最后修改时间
 * @property int|null $last_modified_by 最后修改人
 * @property DateTime|string|null $deleted_at 删除时间
 * @property int|null $deleted_by 删除人
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 */
class Organization extends IdModel
{
    protected $table = 'sys_organization';
    protected $fillable = [];
}
