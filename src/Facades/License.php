<?php
namespace AbnDevs\Installer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AbnDevs\Installer\License
 */
class License extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AbnDevs\Installer\License::class;
    }
}
