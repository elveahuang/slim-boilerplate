<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use Illuminate\Database\Eloquent\Model;

abstract class IdModel extends Model
{
    use IdPrimaryKey;
}
