<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\IdModel;
use App\Models\Announcement;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends EntityRepository<Attachment>
 */
class AttachmentRepository extends EntityRepository
{

    /**
     * @return Model|IdModel|Announcement
     */
    public function getModel(): Model|IdModel|Announcement
    {
        return new Announcement();
    }

}
