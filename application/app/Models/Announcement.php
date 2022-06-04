<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Libraries\Database\IdModel;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id 主键
 * @property string $title 标题
 * @property string $content 内容
 * @property string $description 备注说明
 * @property int $index_ 序号
 * @property int $active 启用状态
 * @property DateTime|string|null $created_at 创建时间
 * @property int|null $created_by 创建人
 * @property DateTime|string|null $last_modified_at 最后修改时间
 * @property int|null $last_modified_by 最后修改人
 * @property DateTime|string|null $deleted_at 删除时间
 * @property int|null $deleted_by 删除人
 * @method static Builder|Attachment newModelQuery()
 * @method static Builder|Attachment newQuery()
 * @method static Builder|Attachment query()
 */
class Announcement extends IdModel
{
}
