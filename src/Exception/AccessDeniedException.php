<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccessDeniedException as SecurityException;

class AccessDeniedException extends SecurityException
{
}
