<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{
    
    
    /*
    |--------------------------------------------------------------------------
    | Base Site URL
    |--------------------------------------------------------------------------
    |
    | URL to your CodeIgniter root. Typically this will be your base URL,
    | WITH a trailing slash:
    |
    |   http://example.com/
    |
    | If not set, CodeIgniter will try to guess the protocol, domain and
    | path to your installation. However, you should always configure this
    | explicitly and never rely on auto-guessing, especially in production
    | environments.
    |
    */
    public $baseURL = 'http://localhost/';

    /*
    |--------------------------------------------------------------------------
    | Index File
    |--------------------------------------------------------------------------
    |
    | Typically this will be your index.php file, unless you've renamed it to
    | something else. If you are using mod_rewrite to remove the page set this
    | variable so that it is blank.
    |
    */
    public $indexPage = 'index.php';

    /*
    |--------------------------------------------------------------------------
    | URI PROTOCOL
    |--------------------------------------------------------------------------
    |
    | This item determines which server global should be used to retrieve the
    | URI string. The default setting of 'REQUEST_URI' works for most servers.
    | If your links do not seem to work, try one of the other delicious flavors:
    |
    | 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
    | 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
    | 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
    |
    */
    public $uriProtocol = 'REQUEST_URI';

    /*
    |--------------------------------------------------------------------------
    | Default Locale
    |--------------------------------------------------------------------------
    |
    | The Locale roughly represents the language and location that your
    | visitor is viewing the site from. It affects the language strings and
    | other strings (like currency markers, etc), that your program
    | should run under for this request.
    |
    */
    public $defaultLocale = 'en';

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | The default timezone for your application. This will be used when
    | displaying dates to users or storing timestamps in the database.
    |
    */
    public $appTimezone = 'America/Guatemala';

    /*
    |--------------------------------------------------------------------------
    | Character Set
    |--------------------------------------------------------------------------
    |
    | The character set used in HTML documents and rendered by the
    | browser.
    |
    */
    public $charset = 'UTF-8';

    /*
    |--------------------------------------------------------------------------
    | Enable Hooks
    |--------------------------------------------------------------------------
    |
    | Enables the system to call hooks defined in the configuration file
    | at specific points during execution.
    |
    */
    public $enableHooks = false;

    /*
    |--------------------------------------------------------------------------
    | Cookie Settings
    |--------------------------------------------------------------------------
    |
    | Cookie-related settings, such as the name of the cookie, path, domain,
    | security, etc.
    |
    */
    public $cookiePrefix = '';
    public $cookieDomain = '';
    public $cookiePath = '/';
    public $cookieSecure = false;
    public $cookieHTTPOnly = false;

    /*
    |--------------------------------------------------------------------------
    | Reverse Proxy IPs
    |--------------------------------------------------------------------------
    |
    | If your server is behind a reverse proxy, you must whitelist the proxy IP
    | addresses from which CodeIgniter should trust headers such as HTTP_CLIENT_IP
    | and HTTP_X_FORWARDED_FOR in order to properly identify the IP address
    | of the client.
    |
    */
    public array $proxyIPs = [];

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    | Cross Site Request Forgery protection settings.
    |
    */
    public $CSRFTokenName = 'csrf_test_name';
    public $CSRFHeaderName = 'X-CSRF-TOKEN';
    public $CSRFCookieName = 'csrf_cookie_name';
    public $CSRFExpire = 7200;
    public $CSRFRegenerate = true;
    public $CSRFRedirect = true;

    /*
    |--------------------------------------------------------------------------
    | Content Security Policy
    |--------------------------------------------------------------------------
    |
    | Enables the Content-Security-Policy HTTP response header. For more
    | information, see the Mozilla Developer Network's article at:
    | https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP
    |
    */
    public $CSPEnabled = false;

    /*
    |--------------------------------------------------------------------------
    | Logger Threshold
    |--------------------------------------------------------------------------
    |
    | You can enable error logging by setting a threshold over zero. The
    | threshold determines what gets logged. Any threshold above zero will
    | cause the logger to be used.
    |
    | 0 = Disables logging, Error logging TURNED OFF
    | 1 = Emergency Messages
    | 2 = Alert Messages
    | 3 = Critical Messages
    | 4 = Runtime Errors
    | 5 = Warnings
    | 6 = Notices
    | 7 = Info Messages
    | 8 = Debug Messages
    | 9 = All Messages
    |
    */
    public $logThreshold = [9];

    /*
    |--------------------------------------------------------------------------
    | Logger File Settings
    |--------------------------------------------------------------------------
    |
    | Configure how the log files are created and stored.
    |
    */
    public $logPath = '';
    public $logFileExtension = '';
    public $logFilePermissions = 0644;
    public $dateFormat = 'Y-m-d H:i:s';

    /*
    |--------------------------------------------------------------------------
    | Cache Directory
    |--------------------------------------------------------------------------
    |
    | The directory where cache files should be stored. If empty, it will use
    | the system's default cache directory.
    |
    */
    public $cachePath = WRITEPATH . 'cache/';

    /*
    |--------------------------------------------------------------------------
    | Application Version
    |--------------------------------------------------------------------------
    |
    | Current version of the application.
    |
    */
    public $appVersion = '1.0.0';

    public $allowedHostnames = [];

    public $forceGlobalSecureRequests = false;

    public $supportedLocales = ['en', 'es', 'fr'];

    public $negotiateLocale = false;

}
