<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\DB;


class LogRequests
{
    /**
     * Handles the request and returns the response.
     *
     * @param Request $request The HTTP request object.
     * @param Closure $next The closure representing the next middleware in the pipeline.
     * @throws Exception If an error occurs while handling the request.
     * @return mixed The response returned by the next middleware.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        // Measure the start time
        $start = microtime(true);

        // Your existing code here...

        // Measure the end time
        $end = microtime(true);

        // Calculate the page response time
        $pageResponseTime = ($end - $start) * 1000; // Convert to milliseconds

        // Register a database query listener
        $queryTime = 0; // Initialize the query time to 0
        // DB::listen(function ($query) {
        //     // You can log the query time or store it in a variable for later use
        //     $queryTime = $query->time;
        // });

        // Modified user agent
        $browser = Agent::browser();
        $platform = Agent::platform();


        if (Auth::check()) {
            $log = new Log();
            $log->http_method = $request->method();
            $log->url = $request->fullUrl();
            $log->http_status = $response->getStatusCode();
            $log->color = $this->getStatusColor($response->getStatusCode());
            $log->user_id = Auth::id();
            $log->ip_address = $request->ip();
            // $log->user_agent = Agent::getUserAgent();
            $log->user_agent = $browser . ' - ' . $platform;
            $log->page_response_time = $pageResponseTime; // Add the page response time
            // $log->db_query_time = $queryTime ?? 'NULL'; // Add the database query time
            // Calculate the total database query time

            if (class_exists(DBlogQueries::class)) {
                $queries = DB::getQueryLog();
                foreach ($queries as $query) {
                    $queryTime += $query['time'];
                }

                $log->db_query_time = $queryTime;
            }
            
            $log->save();
        }

        return $response;
    }

    private function getStatusColor($statusCode)
    {
        if ($statusCode >= 200 && $statusCode < 300) {
            // 2xx Success Responses - Green
            return 'green';
        } elseif ($statusCode >= 300 && $statusCode < 400) {
            // 3xx Redirection Responses - Yellow
            return 'yellow';
        } else {
            // 4xx Client Error Responses and 5xx Server Error Responses - Red
            return 'red';
        }
    }
    
}

