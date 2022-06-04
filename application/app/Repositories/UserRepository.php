<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<User>
 */
class UserRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|User
     */
    public function getModel(): Model|IdModel|User
    {
        return new User();
    }

    /**
     * @param string $username
     * @return User
     */
    public function findByUsername(string $username): object
    {
        return $this->newQuery()->firstWhere([
            'username' => $username
        ]);
    }

}
