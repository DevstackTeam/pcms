<?php

namespace App\Services;

class PermissionSeederService
{
    public static function permissions(){
        return [
            'User' => [
                'Create User' => 'Create User',
                'View User' => 'View User',
                'Update User' => 'Update User',
                'Delete User' => 'Delete User',
            ],
            'Role' => [
                'Create Role' => 'Create Role',
                'View Role' => 'View Role',
                'Update Role' => 'Update Role',
                'Delete Role' => 'Delete Role',
            ],
            'Designation' => [
                'Create Designation' => 'Create Designation',
                'View Designation' => 'View Designation',
                'Update Designation' => 'Update Designation',
                'Delete Designation' => 'Delete Designation',
            ],
            'Project' => [
                'Create Project' => 'Create Project',
                'View Project' => 'View Project',
                'Update Project' => 'Update Project',
                'Delete Project' => 'Delete Project',
            ],
            'Scenario' => [
                'Create Scenario' => 'Create Scenario',
                'View Scenario' => 'View Scenario',
                'Update Scenario' => 'Update Scenario',
                'Delete Scenario' => 'Delete Scenario',
            ],
            'Manpower' => [
                'Create Manpower' => 'Create Manpower',
                'View Manpower' => 'View Manpower',
                'Update Manpower' => 'Update Manpower',
                'Delete Manpower' => 'Delete Manpower',
            ],
        ];
    }

    public static function super_admin(){
        return [
            'Create User',
            'View User',
            'Update User',
            'Delete User',

            'Create Role',
            'View Role',
            'Update Role',
            'Delete Role',
        ];
    }

    public static function admin(){
        return [
            'Create Designation',
            'View Designation',
            'Update Designation',
            'Delete Designation',

            'Create Project',
            'View Project',
            'Update Project',
            'Delete Project',

            'Create Scenario',
            'View Scenario',
            'Update Scenario',
            'Delete Scenario',

            'Create Manpower',
            'View Manpower',
            'Update Manpower',
            'Delete Manpower',
        ];
    }

    public static function user(){
        return [
            'View Designation',

            'View Project',

            'View Scenario',

            'View Manpower',
        ];
    }
}
