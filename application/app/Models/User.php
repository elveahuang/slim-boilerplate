<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id ID
 * @property string|null $username 用户名
 * @property string|null $email 邮箱
 * @property string|null $mobile_country_code 手机国家区号
 * @property string|null $mobile 手机
 * @property string|null $password 密码
 * @property string|null $name 全名
 * @property string|null $display_name 昵称
 * @property string|null $id_card_type 证件类型
 * @property string|null $id_card_no 证件号码
 * @property string|null $sex 性别
 * @property DateTime|string|null $birthday 生日
 * @property string|null $description 备注
 * @property string|null $last_login_status 最后登录状态
 * @property string|null $last_login_at 最后登录时间
 * @property string|null $password_expire_at 密码过期时间
 * @property string|null $password_error_at 最后一次输入错误密码的时间
 * @property int $password_error_count 输入错误密码的次数
 * @property int $status 用户状态
 * @property int $source 用户来源
 * @property int $active 启用状态
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @property DateTime|string|null $last_modified_at 最后修改时间
 * @property int|null $last_modified_by 最后修改人
 * @property DateTime|string|null $deleted_at 删除时间
 * @property int|null $deleted_by 删除人
 * @property-read Collection|Role[] $roles
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User where()
 */
class User extends IdModel
{

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'last_modified_at';

    /**
     * @var string
     */
    protected $table = 'sys_user';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'username', 'email', 'display_name', 'mobile'];

    protected $hidden = ['password'];

}
