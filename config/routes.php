<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    $routes->connect('/properties', ['controller' => 'Pages', 'action' => 'home']);
    $routes->connect('/properties/:property_id', ['controller' => 'Pages', 'action' => 'properties'])->setPass(['property_id']);
    $routes->connect('/properties/:property_id/comments', ['controller' => 'Comments', 'action' => 'add'])->setPass(['property_id']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    Router::scope('/admin/properties', function ($routes) {
        $routes->connect('/',['controller' => 'Properties', 'action' => 'index']); 
        $routes->connect('/add',['controller' => 'Properties', 'action' => 'add']);  
        $routes->connect('/edit/:property_id',['controller' => 'Properties', 'action' => 'edit'])->setPass(['property_id']);
        $routes->connect('/:property_id',['controller' => 'Properties', 'action' => 'view'])->setPass(['property_id']);
    });

    Router::scope('/admin/properties/:property_id/pictures', function ($routes) {
        $routes->connect('/',['controller' => 'Pictures', 'action' => 'index'])->setPass(['property_id']);
        $routes->connect('/add',['controller' => 'Pictures', 'action' => 'add'])->setPass(['property_id']);
        $routes->connect('/delete/:id',['controller' => 'Pictures', 'action' => 'delete'])->setPass(['property_id', 'id']);
    });

    Router::scope('/admin/agency', function ($routes) {
        $routes->connect('/',['controller' => 'Agencies', 'action' => 'view']);
        $routes->connect('/edit',['controller' => 'Agencies', 'action' => 'edit']);
    });

    // Router::scope('/comments', function ($routes) {
    //     $routes->connect('/',['controller' => 'Comment', 'action' => 'index']); 
    //     $routes->connect('/view/*',['controller' => 'Comment', 'action' => 'view']);  
    // });

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});
