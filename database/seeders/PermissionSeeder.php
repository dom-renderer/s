<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resourcePermissionsScaffolding = [
            [
                'title' => ' Listing',
                'name' => '.index'
            ],
            [
                'title' => ' Add',
                'name' => '.create'
            ],
            [
                'title' => ' Save',
                'name' => '.store'
            ],
            [
                'title' => ' Edit',
                'name' => '.edit'
            ],
            [
                'title' => ' Update',
                'name' => '.update'
            ],
            [
                'title' => 'View',
                'name' => '.show'
            ],
            [
                'title' => ' Delete',
                'name' => '.destroy'
            ]
        ];

        $resourcePermissions = [
            [
                'title' => 'Users',
                'name' => 'users'
            ],
            [
                'title' => 'Roles',
                'name' => 'roles'
            ],
            [
                'title' => 'Vehicle Classes',
                'name' => 'vehicle-classes'
            ],
            [
                'title' => 'Vehicle Transmissions',
                'name' => 'vehicle-transmissions'
            ],
            [
                'title' => 'Vehicle Types',
                'name' => 'vehicle-types'
            ],
            [
                'title' => 'Locations',
                'name' => 'locations'
            ],
            [
                'title' => 'Vehicles',
                'name' => 'vehicles'
            ]
        ];

        $extraPermissions = [
            [
                'title' => 'App Settings Information',
                'name' => 'settings.index'
            ],
            [
                'title' => 'App Settings Update',
                'name' => 'settings.update'
            ]
        ];

        $permissions = [];

        foreach ($resourcePermissions as $rP) {
            foreach ($resourcePermissionsScaffolding as $scaffold) {
                $permissions[] = [
                    'title' => $rP['title'] . $scaffold['title'],
                    'name' => $rP['name'] . $scaffold['name']
                ];
            }
        }

        $permissions = array_merge($permissions, $extraPermissions);

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }
    }
}