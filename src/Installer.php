<?php

namespace AbnDevs\Installer;

class Installer
{
    public static function rememberStep($step): bool
    {
        // Remember the step to the file
        $path = storage_path('app/installer');

        if (!is_dir($path)) {
            mkdir($path);
        }

        file_put_contents($path.'/'. $step, true);

        return true;
    }

    public static function isStepDone($step): bool
    {
        // Check if the step is done
        $path = storage_path('app/installer');

        if (!is_dir($path)) {
            return false;
        }

        return file_exists($path.'/'. $step);
    }

    public static function forgotStep($step)
    {
        // Forget the step
        $path = storage_path('app/installer');

        if (!is_dir($path)) {
            return false;
        }

        if (file_exists($path.'/'. $step)) {
            unlink($path.'/'. $step);
        }
    }
}
