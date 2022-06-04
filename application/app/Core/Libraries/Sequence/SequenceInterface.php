<?php
declare(strict_types=1);

namespace App\Core\Libraries\Sequence;

/**
 * Class SequenceInterface
 * @package App\Core\Libraries\Sequence
 */
interface SequenceInterface
{

    /**
     * @return int
     */
    public function nextId(): int;

}
