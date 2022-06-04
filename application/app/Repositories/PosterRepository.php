<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Poster;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Poster>
 */
class PosterRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Poster
     */
    public function getModel(): Model|IdModel|Poster
    {
        return new Poster();
    }

}
