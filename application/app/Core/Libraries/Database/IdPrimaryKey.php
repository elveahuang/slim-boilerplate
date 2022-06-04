<?php
declare(strict_types=1);

namespace App\Core\Libraries\Database;

use App\Core\Libraries\Sequence\SequenceManagerFactory;
use Exception;

trait IdPrimaryKey
{

    /**
     * @throws Exception
     */
    public static function bootIdPrimaryKey()
    {
        static::saving(function ($model) {
            if (is_null($model->getKey())) {
                $model->setIncrementing(false);
                $keyName = $model->getKeyName();
                $model->setAttribute($keyName, SequenceManagerFactory::getInstance()->nextId());
            }
        });
    }

}
