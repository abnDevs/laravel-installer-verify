<?php
namespace AbnDevs\Installer\Http\Controllers;

use AbnDevs\Installer\Facades\License;
use AbnDevs\Installer\Http\Requests\StoreDatabaseRequest;
use App\Http\Controllers\Controller;
use Brotzka\DotenvEditor\DotenvEditor;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function __construct(readonly DotenvEditor $dotenvEditor)
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
    }

    public function index()
    {
        return view('installer::database');
    }

    public function store(StoreDatabaseRequest $request)
    {
        try {
            $this->checkDatabaseConnection($request);

            // Check if database is empty
            $tables = DB::select('SHOW TABLES');

            if (! empty($tables) && ! $request->validated('force')) {
                return error('Database is not empty.', data: [
                    'ask_for_force' => true,
                ]);
            }
        } catch (Exception $e) {
            return error('Please check your database credentials');
        }

        // Save database credentials
        try {
            $this->dotenvEditor->addData([
                'DB_CONNECTION' => $request->validated('driver'),
                'DB_HOST' => $request->validated('host'),
                'DB_PORT' => $request->validated('port'),
                'DB_DATABASE' => $request->validated('database'),
                'DB_USERNAME' => $request->validated('username'),
                'DB_PASSWORD' => $request->validated('password'),
            ]);

            // Migrate database
            Artisan::call('migrate:fresh --seed --force');
            Artisan::call('storage:link');

            Cache::put('installer.agreement', true);
            Cache::put('installer.requirements', true);
            Cache::put('installer.permissions', true);
            Cache::put('installer.database', true);

            return response()->json([
                'status' => 'success',
                'message' => 'Database credentials saved successfully',
                'redirect' => route('installer.admin.index'),
            ]);
        } catch (Exception $e) {
            Cache::forget('installer.database');
            return error($e->getMessage());
        }
    }

    /**
     * Check database connection
     */
    private function checkDatabaseConnection(StoreDatabaseRequest $request): void
    {
        $driver = $request->validated('driver');

        $settings = config("database.connections.$driver");

        $connectionArray = array_merge($settings, [
            'driver' => $driver,
            'database' => $request->validated('database'),
            'username' => $request->validated('username'),
            'password' => $request->validated('password'),
            'host' => $request->validated('host'),
            'port' => $request->validated('port'),
        ]);

        config([
            'database' => [
                'migrations' => 'migrations',
                'default' => $driver,
                'connections' => [$driver => $connectionArray],
            ],
        ]);

        DB::purge($driver);

        DB::connection()->getPdo();
    }
}
