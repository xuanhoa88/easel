<?php

namespace Canvas\Meta;

/**
 * A home for global Canvas constants.
 */
class Constants 
{
    /**
     * @constant(ROLE_USER)
     */
    const ROLE_USER = 0;

    /**
     * @constant(ROLE_ADMINISTRATOR)
     */
    const ROLE_ADMINISTRATOR = 1;

    /**
     * @constant(MAINTENANCE_MODE_ENABLED)
     */
    const MAINTENANCE_MODE_ENABLED = 0;

    /**
     * @constant(MAINTENANCE_MODE_DISABLED)
     */
    const MAINTENANCE_MODE_DISABLED = 1;

    /**
     * @constant(CORE_PACKAGE)
     */
    const CORE_PACKAGE = 'cnvs/easel';

    /**
     * @constant(DEFAULT_THEME_NAME)
     */
    const DEFAULT_THEME_NAME = 'Unthemed (Paper)';

    /**
     * @constant(DEFAULT_THEME_NAME)
     */
    const DEFAULT_THEME_VERSION = '1.0';
}