<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id ID
 * @property int $parent_id 祖先ID
 * @property string|null $code 编码
 * @property string|null $title 标题
 * @property string|null $label 多语言文本
 * @property string|null $description 备注
 * @property int $type_ 权限类型
 * @property int $index_ 排序序号
 * @property boolean $active 层级序号
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @property DateTime|string|null $last_modified_at 最后修改时间
 * @property int|null $last_modified_by 最后修改人
 * @property DateTime|string|null $deleted_at 删除时间
 * @property int|null $deleted_by 删除人
 * @method static Builder|UserSession newModelQuery()
 * @method static Builder|UserSession newQuery()
 * @method static Builder|UserSession query()
 */
class Authority extends IdModel
{
    protected $table = 'sys_authority';
    protected $fillable = [];
}
