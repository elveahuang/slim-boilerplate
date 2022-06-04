<?php
declare(strict_types=1);

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnnouncementMgrController;
use App\Http\Controllers\Admin\PosterMgrController;
use App\Http\Controllers\Admin\TagMgrController;
use App\Http\Controllers\Admin\UserMgrController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthenticationMiddleware;
use App\Http\Middleware\AuthorizationMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    /**
     * 登录认证接口
     */
    $app->group('/api/auth', function (Group $group) {
        $group->post('/token', [AuthController::class, 'token'])->setName('auth-token');
        $group->post('/logout', [AuthController::class, 'logout'])->setName('auth-logout');
    });

    /**
     * 前台接口，无需登录授权
     */
    $app->group('/api', function (Group $group) {
        // 通用
        $group->get('/initialize', [DefaultController::class, 'initialize']);
        $group->get('/home', [DefaultController::class, 'home']);
        // 用户
        $group->post('/register', [UserController::class, 'register']);
        $group->post('/forgot-password', [UserController::class, 'forgotPassword']);
    });

    /**
     * 前台接口，需要登录授权
     */
    $app->group('/api', function (Group $group) {
        // 通用
        $group->get('/version', [DefaultController::class, 'version']);
        // 用户
        $group->get('/user', [UserController::class, 'user'])->setName('api-user');
        $group->get('/user/account', [UserController::class, 'account'])->setName('api-user-account');
        $group->get('/user/reset-password', [UserController::class, 'resetPassword'])->setName('api-user-reset-password');
    })->add(AuthenticationMiddleware::class)->add(AuthorizationMiddleware::class);

    /**
     * 后台管理
     */
    $app->group('/api/admin', function (Group $group) {
        // 仪表盘和工作台
        $group->post('/dashboard', [AdminController::class, 'dashboard']);
        // 用户
        $group->get('/user/view/{id}', [UserMgrController::class, 'view']);
        $group->post('/user/delete/{id}', [UserMgrController::class, 'delete']);
        $group->post('/user/save', [UserMgrController::class, 'save']);
        $group->post('/user/search', [UserMgrController::class, 'search']);
        $group->post('/user/reset-password', [UserMgrController::class, 'search']);
        // 宣传栏
        $group->get('/poster/view/{id}', [PosterMgrController::class, 'view']);
        $group->post('/poster/delete/{id}', [PosterMgrController::class, 'delete']);
        $group->post('/poster/save', [PosterMgrController::class, 'save']);
        $group->post('/poster/search', [PosterMgrController::class, 'search']);
        // 标签
        $group->get('/tag/view/{id}', [TagMgrController::class, 'view']);
        $group->post('/tag/delete/{id}', [TagMgrController::class, 'delete']);
        $group->post('/tag/save', [TagMgrController::class, 'save']);
        $group->post('/tag/search', [TagMgrController::class, 'search']);
        // 资讯
        $group->get('/announcement/view/{id}', [AnnouncementMgrController::class, 'view']);
        $group->post('/announcement/delete/{id}', [AnnouncementMgrController::class, 'delete']);
        $group->post('/announcement/save', [AnnouncementMgrController::class, 'save']);
        $group->post('/announcement/search', [AnnouncementMgrController::class, 'search']);
    })->add(AuthenticationMiddleware::class)->add(AuthorizationMiddleware::class);

};
