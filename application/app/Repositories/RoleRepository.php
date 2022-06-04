<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Role>
 */
class RoleRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Role
     */
    public function getModel(): Model|IdModel|Role
    {
        return new Role();
    }

}
