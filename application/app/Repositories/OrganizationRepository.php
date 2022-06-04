<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Announcement;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Organization>
 */
class OrganizationRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Organization
     */
    public function getModel(): Model|IdModel|Organization
    {
        return new Announcement();
    }

}
