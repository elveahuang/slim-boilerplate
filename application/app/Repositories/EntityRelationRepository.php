<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\EntityRelation;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<EntityRelation>
 */
class EntityRelationRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|EntityRelation
     */
    public function getModel(): Model|IdModel|EntityRelation
    {
        return new EntityRelation();
    }

}
