<?php
namespace AbnDevs\Installer\Http\Controllers;

use AbnDevs\Installer\Http\Requests\StoreAdminRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        if (! Cache::get('installer.agreement')) {
            flash('Please agree to the terms and conditions.', 'error');

            return redirect()->route('installer.agreement.index');
        }

        if (! Cache::get('installer.requirements')) {
            flash('Please check the requirements.', 'error');

            return redirect()->route('installer.requirements.index');
        }

        if (! Cache::get('installer.permissions')) {
            flash('Please check the folder permissions.', 'error');

            return redirect()->route('installer.permissions.index');
        }

        if (! Cache::get('installer.database')) {
            flash('Please configure your database connection.', 'error');

            return redirect()->route('installer.database.index');
        }
    }

    public function index()
    {
        return view('installer::admin');
    }

    public function store(StoreAdminRequest $request)
    {
        $superAdmin = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => bcrypt($request->validated('password')),
            ...config('installer.admin.extra')
        ]);

        if (config('installer.admin.has_role')) {
            if (! Role::where('name', config('installer.admin.role', 'Super Admin'))->exists()) {
                Role::create(['name' => config('installer.admin.role')]);
            }

            $superAdmin->assignRole(config('installer.admin.role'));
        }

        Cache::put('installer.admin', true);

        return success(trans('Admin Created Successfully'), route('installer.finish.index'));
    }
}
