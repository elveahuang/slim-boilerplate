<?php
declare(strict_types=1);

use App\Repositories\AnnouncementRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\AuthorityRepository;
use App\Repositories\EntityRelationRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\PositionRepository;
use App\Repositories\PosterRepository;
use App\Repositories\RoleAuthorityRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Repositories\UserSessionRepository;
use App\Services\AnnouncementService;
use App\Services\AttachmentService;
use App\Services\AuthorityService;
use App\Services\OrganizationService;
use App\Services\PositionService;
use App\Services\PosterService;
use App\Services\RoleService;
use App\Services\TagService;
use App\Services\UserService;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        //
        UserRepository::class => autowire(UserRepository::class),
        UserSessionRepository::class => autowire(UserSessionRepository::class),
        UserRoleRepository::class => autowire(UserRoleRepository::class),
        RoleRepository::class => autowire(RoleRepository::class),
        RoleAuthorityRepository::class => autowire(RoleAuthorityRepository::class),
        EntityRelationRepository::class => autowire(EntityRelationRepository::class),
        OrganizationRepository::class => autowire(OrganizationRepository::class),
        PositionRepository::class => autowire(PositionRepository::class),
        AnnouncementRepository::class => autowire(AnnouncementRepository::class),
        AttachmentRepository::class => autowire(AttachmentRepository::class),
        AuthorityRepository::class => autowire(AuthorityRepository::class),
        PosterRepository::class => autowire(PosterRepository::class),
        TagRepository::class => autowire(TagRepository::class),
        //
        AnnouncementService::class => autowire(AnnouncementService::class),
        AttachmentService::class => autowire(AttachmentService::class),
        AuthorityService::class => autowire(AuthorityService::class),
        PosterService::class => autowire(PosterService::class),
        RoleService::class => autowire(RoleService::class),
        TagService::class => autowire(TagService::class),
        UserService::class => autowire(UserService::class),
        OrganizationService::class => autowire(OrganizationService::class),
        PositionService::class => autowire(PositionService::class),
    ]);
};
