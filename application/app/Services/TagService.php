<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityService;
use App\Models\Tag;
use App\Repositories\TagRepository;

/**
 * @extends EntityService<Tag, TagRepository>
 */
class TagService extends EntityService
{

    public function getRepositoryClass(): string
    {
        return TagRepository::class;
    }

}
