<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Authority;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Authority>
 */
class AuthorityRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Authority
     */
    public function getModel(): Model|IdModel|Authority
    {
        return new Authority();
    }

}
