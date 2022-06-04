<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use App\Core\Libraries\Database\Events\ModelCreated;
use App\Core\Libraries\Database\Events\ModelDeleted;
use App\Core\Libraries\Database\Events\ModelUpdated;

abstract class BaseIdModel extends IdModel
{

    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ModelCreated::class,
        'updated' => ModelUpdated::class,
        'deleted' => ModelDeleted::class,
    ];

}
