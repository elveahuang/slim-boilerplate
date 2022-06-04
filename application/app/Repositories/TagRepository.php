<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Tag>
 */
class TagRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Tag
     */
    public function getModel(): Model|IdModel|Tag
    {
        return new Tag();
    }

}
