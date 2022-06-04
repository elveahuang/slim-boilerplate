<?php

namespace App\Core\Libraries\Database\Events;

use App\Core\Libraries\Database\BaseIdModel;

class ModelCreated
{
    /**
     * @param BaseIdModel $model
     */
    public function __construct(BaseIdModel $model)
    {
        $model->setAttribute('created_by', 1);
    }

}
