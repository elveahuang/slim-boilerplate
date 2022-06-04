<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id ID
 * @property int $role_id 角色ID
 * @property int $authority_id 权限ID
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 */
class RoleAuthority extends IdModel
{

    protected $table = 'sys_role_authority';

    protected $fillable = [];

}
