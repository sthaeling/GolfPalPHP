<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\HttpFoundation\Request;

class CookieHelper
{
    public function setCookie(string $name, string $value): bool
    {
        return setcookie($name, $value);
    }

    public function readCookie(string $name, Request $request): ?string
    {
        return $request->cookies->get($name) ?? null;
    }

    public function deleteCookie(string $name, Request $request)
    {
        $request->cookies->remove($name);
    }
}
