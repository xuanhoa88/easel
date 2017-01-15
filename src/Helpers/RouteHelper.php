<?php

namespace Canvas\Helpers;

class RouteHelper extends CanvasHelper
{
    /**
     * Get General Middleware.
     */
    public static function getGeneralMiddleware()
    {
        return self::ROUTE_MIDDLEWARE_GENERAL;
    }

    /**
     * Get Safe Middleware.
     */
    public static function getInstalledMiddleware()
    {
        return self::ROUTE_MIDDLEWARE_INSTALLED;
    }

    /**
     * Get Admin Middleware.
     */
    public static function getAdminMiddleware()
    {
        return self::ROUTE_MIDDLEWARE_ADMIN;
    }

    /**
     * Get General Middleware Groups.
     */
    public static function getGeneralMiddlewareGroups()
    {
        return self::ROUTE_MIDDLEWARE_GROUPS_GENERAL;
    }

    /**
     * Get blog main path.
     */
    public static function getBlogMain()
    {
        $config = ConfigHelper::getWriter();

        return $config->get('blog_path') ?: self::ROUTE_DEFAULT_BLOG_MAIN;
    }

    /**
     * Get blog prefix.
     */
    public static function getBlogPrefix()
    {
        $config = ConfigHelper::getWriter();

        return $config->get('blog_prefix') ?: self::ROUTE_DEFAULT_BLOG_PREFIX;
    }

    /**
     * Get admin prefix.
     */
    public static function getAdminPrefix()
    {
        $config = ConfigHelper::getWriter();

        return $config->get('admin_prefix') ?: self::ROUTE_DEFAULT_ADMIN_PREFIX;
    }

    /**
     * Get auth prefix.
     */
    public static function getAuthPrefix()
    {
        $config = ConfigHelper::getWriter();

        return $config->get('auth_prefix') ?: self::ROUTE_DEFAULT_AUTH_PREFIX;
    }

    /**
     * Get password prefix.
     */
    public static function getPasswordPrefix()
    {
        $config = ConfigHelper::getWriter();

        return $config->get('password_prefix') ?: self::ROUTE_DEFAULT_PASSWORD_PREFIX;
    }

    /**
     * Retrieve a route path. Route without server name etc.
     * @param string $routeName
     * @return string Path
     */
    public static function routePath($routeName)
    {
        $request = resolve('request');

        return preg_replace("/https?:\/\/{$request->server->get('SERVER_NAME')}\//", null, route($routeName));
    }
}
