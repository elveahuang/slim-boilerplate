<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id ID
 * @property int $ancestor_id 祖先ID
 * @property int $entity_id 实体ID
 * @property string $relation_type 关联类型
 * @property boolean $parent_ind 是否直接上级
 * @property string $path_ 层级路径
 * @property int $index_ 层级序号
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @method static Builder|UserSession newModelQuery()
 * @method static Builder|UserSession newQuery()
 * @method static Builder|UserSession query()
 */
class EntityRelation extends IdModel
{
    protected $table = 'sys_entity_relation';
    protected $fillable = [];
}
