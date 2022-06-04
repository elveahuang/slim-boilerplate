<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\User;
use App\Models\UserSession;
use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<UserSession>
 */
class UserSessionRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|UserSession
     */
    public function getModel(): Model|IdModel|UserSession
    {
        return new UserSession();
    }

    /**
     * @param string $sessionId
     * @return UserSession
     */
    public function findBySessionId(string $sessionId): object
    {
        return $this->newQuery()->firstWhere([
            'session_id' => $sessionId
        ]);
    }

    /**
     * @return void
     */
    public function createUserSession(UserSession $session)
    {
        $session->save();
    }

    /**
     * @param string $sessionId
     * @param User $user
     * @return void
     */
    public function updateUserSession(string $sessionId, User $user)
    {
        $this->newModelQuery()
            ->where('session_id', $sessionId)
            ->where('user_id', $user['id'])
            ->update(['last_access_datetime' => new DateTime()]);
    }

    /**
     * @param string $sessionId
     * @return void
     */
    public function removeUserSession(string $sessionId)
    {
        $this->newModelQuery()
            ->where('session_id', $sessionId)
            ->update(['end_datetime' => new DateTime()]);
    }

}
