<?php

namespace App\Http\Middleware;

use Closure;
use UnitedPrototype\GoogleAnalytics;

class AnalyticsTracking
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Initilize GA Tracker
        $tracker = new GoogleAnalytics\Tracker('UA-20435634-1', 'example.com');

        // Assemble Visitor information
        // (could also get unserialized from database)
        $visitor = new GoogleAnalytics\Visitor();
        $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
        $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $visitor->setScreenResolution('1024x768');

        // Assemble Session information
        // (could also get unserialized from PHP session)
        $session = new GoogleAnalytics\Session();

        // Assemble Page information
        $page = new GoogleAnalytics\Page('/'.$request->path());
        $page->setTitle($request->url());

        // Track page view
        $tracker->trackPageview($page, $session, $visitor);

        return $next($request);
    }

}