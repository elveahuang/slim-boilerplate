<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Libraries\Database\EntityService;
use App\Models\Poster;
use App\Repositories\PosterRepository;

/**
 * @extends EntityService<Poster, PosterRepository>
 */
class PosterService extends EntityService
{

    public function getRepositoryClass(): string
    {
        return PosterRepository::class;
    }

}
