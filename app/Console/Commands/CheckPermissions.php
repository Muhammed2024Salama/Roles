<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissionsID = [1, 2, 3];
        $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $permissionsID)->where('guard_name', 'sanctum')->get();
        dd($permissions);
    }
}
