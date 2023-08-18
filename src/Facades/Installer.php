<?php
namespace AbnDevs\Installer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AbnDevs\Installer\Installer
 */
class Installer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \AbnDevs\Installer\Installer::class;
    }
}
