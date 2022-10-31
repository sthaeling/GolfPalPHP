<?php

declare(strict_types=1);

namespace App\Service\User;

use App\CookieHelper;
use Symfony\Component\HttpFoundation\Request;

class SelectUser
{
    private CookieHelper $cookieHelper;

    /**
     * @param CookieHelper $cookieHelper
     */
    public function __construct(CookieHelper $cookieHelper)
    {
        $this->cookieHelper = $cookieHelper;
    }

    public function selectUser(string $userId): bool
    {
        return $this->cookieHelper->setCookie('userId', $userId);
    }

    public function getSelectedUser(Request $request): ?string
    {
        return $this->cookieHelper->readCookie('userId', $request);
    }
}
