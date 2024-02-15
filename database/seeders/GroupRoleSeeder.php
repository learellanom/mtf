<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group_role;

class GroupRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Group_role::create(['role_id'=>'10', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'11', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'12', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'13', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'14', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'15', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
        Group_role::create(['role_id'=>'16', 'group_id'=> null, 'all_wallets'=>'1', 'all_groups'=>'1']);
    }
}
