<?php
declare(strict_types=1);

namespace App\Core\Types;

class Principal
{
    public int $id;
    public string|null $username;
    public string|null $displayName;
    public string|null $name;
    public array $roles;
    public array $authorities;
}
