<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\BaseIdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id ID
 * @property int $user_id 用户ID
 * @property int $session_id 会话ID
 * @property string|null $host 主机
 * @property string|null $device 设备
 * @property string|null $client_id 客户端ID
 * @property string|null $client_version 客户端版本
 * @property string|null $platform 平台
 * @property DateTime|string|null $start_datetime
 * @property DateTime|string|null $last_access_datetime
 * @property DateTime|string|null $end_datetime
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @property DateTime|string|null $last_modified_at 最后修改时间
 * @property int|null $last_modified_by 最后修改人
 * @method static Builder|UserSession newModelQuery()
 * @method static Builder|UserSession newQuery()
 * @method static Builder|UserSession query()
 */
class UserSession extends BaseIdModel
{

    /**
     * @var string|null
     */
    const CREATED_AT = 'created_at';

    /**
     * @var string|null
     */
    const UPDATED_AT = 'last_modified_at';

    /**
     * @var string
     */
    protected $table = 'sys_user_session';

    /**
     * @var string
     */
    protected $fillable = ['user_id', 'session_id', 'created_by'];

}
