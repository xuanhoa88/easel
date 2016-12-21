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
}
