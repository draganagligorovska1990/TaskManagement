<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for managing permissions, as there is still no UI.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $role = Role::create(['name' => 'admin']);
//        $permission = Permission::create(['name' => 'manage all tasks']);

//        $role = Role::find(1);
//        $permission = Permission::find(1);

//        $role->givePermissionTo($permission);
//        $permission->assignRole($role);

//        $user = User::find(1);
//        $user->givePermissionTo($permission);
//        $user->assignRole($role);

//        $user->can('manage all tasks');

        return 0;
    }
}
