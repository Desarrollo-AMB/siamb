<?php

namespace App\Support;

use App\Models\Permission;
use Illuminate\Support\Facades\Route;

class Helper
{
    
    /**
    * Returns a Link tag for import datatables.css
    *
    * @return string
    */
    public static function dataTablesCSS() {
        return '<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">';
    }

    /**
     * Returns a Script tag for import datatables.js
     *
     * @return string
     */
    public static function dataTablesJS() {
        return '<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
                <script src="//cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>';
    }
    
    /**
     * Returns a JS code for Sweet Alert Confirm
     *
     * @param  string  $selector
     * @param  string  $msg
     * @param  string  $formSelector
     * 
     * @return string
     */
    public static function swalConfirm($selector, $msg=null, $formSelector='') {

        $msg = $msg ?: 'Este registro será suspendido en caso de estar en uso y eliminado en caso contrario';

        echo <<<HTML
            <script>
                $(document).on('click', '$selector', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '$msg',
                        icon: 'warning',
                        confirmButtonText: 'Sí!',
                        cancelButtonText: 'Cancelar',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    })
                    .then ((result) => {
                        if (result.value) {
                            form = "$formSelector"
                                ? $('$formSelector')
                                : $('#'+$(this).attr('form-target'));

                            if (this.name) {
                                form.append(`<input name='\${this.name}' value='\${this.value}'>`)
                            }

                            form.submit();
                        }
                    })
                });
            </script>
HTML;
    }

    /**
     * Returns a JS code for a DataTables
     *
     * @param  string  $selector
     * @param  JSON  $options
     * 
     * @return string
     */
    public static function dataTables($selector, $options='{}') {
        echo <<<HTML
        <script>
            $(document).ready(function() {
                $("$selector").DataTable({
                    ...{
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                        },
                    },
                    ...$options
                });
            } );
        </script>
HTML;
    }
    
    
    /**
     * Convert permissions array or int or string to collection
     *
     * @param string|integer|array ...$permission
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function convertPermissionsToCollection(...$permissions)
    {
        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {

                if (empty($permission)) {
                    return false;
                }

                if (!$permission instanceof Permission) {
                    if (is_numeric($permission)) {
                        $permission = Permission::findById(intval($permission));
                    } elseif (is_string($permission)) {
                        $permission = Permission::findByName($permission);
                    }
                }

                return $permission;
            })
            ->filter(function ($permission)
            {
                return $permission instanceof Permission;
            });

        return $permissions;
    }

    /**
     * Check if a route is private
     *
     * @param string $routeName
     * 
     * @return boolean
     */
    public static function isPrivateRoute($routeName)
    {
        $route = Route::getRoutes()->getByName($routeName);

        if ($route) {
            // Check if the access middleware is attached to the route
            return in_array('access', $route->gatherMiddleware());
        }

        return false;
    }

    /**
     * Returns all unnecessary permissions
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUnnecessaryPermissions()
    {
        $permissions = Permission::all()
            ->filter(function ($permission) {
                return !Helper::isPrivateRoute($permission->route_name);
            });

        return $permissions;
    }

    /**
     * Returns all private routes without permission
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getPrivateRoutesWithoutPermission()
    { 
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route){
                $permissionExists = Permission::where('route_name', $route->getName())->get()->count();
                // Check and Return if is a private route and don't have any permission
                return in_array('access', $route->gatherMiddleware()) && !$permissionExists;
            });
        return $routes;
    }

/**
     * Returns all routes without permission
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getRoutesWithoutPermission()
    { 
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route){
                $permissionExists = Permission::where('route_name', $route->getName())->get()->count();
                // Check and Return if don't have any permission
                return !$permissionExists;
            });
return $routes;
    }
    /**
     * Returns the total permissions notifications, counting both 
     * unnecessary permissions and private routes without permission
     *
     * @return int
     */
    public static function getTotalPermissionsNotifications()
    {
        $unnecessaryPermissions = Helper::getUnnecessaryPermissions()->count();
        $privateRoutesWithoutPermission = Helper::getPrivateRoutesWithoutPermission()->count();
        $totalPermissionsNotifications = $unnecessaryPermissions + $privateRoutesWithoutPermission;
        
        return $totalPermissionsNotifications;
    }

}