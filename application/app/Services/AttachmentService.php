<?php

namespace App\Services;

use App\Core\Libraries\Database\EntityRepository;
use App\Core\Libraries\Database\EntityService;
use App\Models\Attachment;
use App\Repositories\AttachmentRepository;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface as Container;
use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\Translation\Translator;

/**
 * @extends EntityService<Attachment, AttachmentRepository>
 */
class AttachmentService extends EntityService
{

    /**
     * @var AttachmentRepository
     */
    private AttachmentRepository $attachmentRepository;

    /**
     * @param Container $container
     * @param Logger $logger
     * @param Translator $translator
     * @param AttachmentRepository $attachmentRepository
     */
    #[Pure] public function __construct(
        Container            $container,
        Logger               $logger,
        Translator           $translator,
        AttachmentRepository $attachmentRepository
    )
    {
        parent::__construct($container, $logger, $translator);
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * @return EntityRepository|AttachmentRepository
     */
    protected function getRepository(): EntityRepository|AttachmentRepository
    {
        return $this->attachmentRepository;
    }

}