<?php

namespace AbnDevs\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    protected array $results = [];

    /**
     * Set the result array permissions and errors.
     *
     * @return void
     */
    public function __construct()
    {
        $this->results['permissions'] = [];

        $this->results['errors'] = null;
    }

    public function index()
    {
        if (Cache::get('installer.agreement') != 1) {
            flash('Please agree to the terms and conditions.', 'error');

            return redirect()->route('installer.agreement.index');
        }

        if (Cache::get('installer.requirements') != 1) {
            flash('Please check the requirements.', 'error');

            return redirect()->route('installer.requirements.index');
        }

        $permissions = $this->check(
            config('installer.permissions')
        );

        $hasError = $permissions['errors'];

        return view('installer::permissions', [
            'permissions' => $permissions['permissions'],
            'hasError' => $hasError,
        ]);
    }

    public function store()
    {
        if (Cache::get('installer.agreement') != 1) {
            flash('Please agree to the terms and conditions.', 'error');

            return redirect()->route('installer.agreement.index');
        }

        if (Cache::get('installer.requirements') !=1 ) {
            flash('Please check the requirements.', 'error');

            return redirect()->route('installer.requirements.index');
        }

        $permissions = $this->check(
            config('installer.permissions')
        );

        $hasError = $permissions['errors'];

        if ($hasError) {
            flash('Please check the permissions.', 'error');

            return redirect()->route('installer.permissions');
        }

        Cache::put('installer.permissions', true);

        return redirect()->route('installer.database.index');
    }

    /**
     * Check for the folders permissions.
     */
    private function check(array $folders): array
    {
        foreach ($folders as $folder => $permission) {
            if (! ($this->getPermission($folder) >= $permission)) {
                $this->addFileAndSetErrors($folder, $permission, false);
            } else {
                $this->addFile($folder, $permission, true);
            }
        }

        return $this->results;
    }

    /**
     * Get a folder permission.
     */
    private function getPermission($folder): string
    {
        return substr(sprintf('%o', fileperms($folder)), -4);
    }

    /**
     * Add the file to the list of results.
     */
    private function addFile($folder, $permission, $isSet): void
    {
        $this->results['permissions'][] = [
            'folder' => $folder,
            'permission' => $permission,
            'isSet' => $isSet,
        ];
    }

    /**
     * Add the file and set the errors.
     */
    private function addFileAndSetErrors($folder, $permission, $isSet): void
    {
        $this->addFile($folder, $permission, $isSet);

        $this->results['errors'] = true;
    }
}
