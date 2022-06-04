<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<UserRole>
 */
class UserRoleRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|UserRole
     */
    public function getModel(): Model|IdModel|UserRole
    {
        return new UserRole();
    }

}
