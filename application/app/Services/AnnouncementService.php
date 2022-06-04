<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityService;
use App\Models\Announcement;
use App\Repositories\AnnouncementRepository;

/**
 * @extends EntityService<Announcement, AnnouncementRepository>
 */
class AnnouncementService extends EntityService
{

    public function getRepositoryClass(): string
    {
        return AnnouncementRepository::class;
    }

}
