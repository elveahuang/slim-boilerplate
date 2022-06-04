<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Position;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Position>
 */
class PositionRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Position
     */
    public function getModel(): Model|IdModel|Position
    {
        return new Position();
    }

}
