<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\RoleAuthority;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<RoleAuthority>
 */
class RoleAuthorityRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|RoleAuthority
     */
    public function getModel(): Model|IdModel|RoleAuthority
    {
        return new RoleAuthority();
    }

    /**
     * @param array $roleIds
     * @return array
     */
    public function findAuthorityIdByRoleIds(array $roleIds = [0]): array
    {
        return $this->newQuery()->whereIn('role_id', $roleIds)->get(['authority_id'])->toArray();
    }

}
