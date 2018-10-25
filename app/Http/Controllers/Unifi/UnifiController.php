<?php

namespace App\Http\Controllers\Unifi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Unifi\AccessLog;
use Carbon\Carbon;
use App\Charts\WifiUsage;

class UnifiController extends Controller
{
    protected $unifiServer;
    protected $unifiUser;
    protected $unifiPassword;

    public function __construct()
    {
        $this->unifiServer = env('UNIFI_SERVER', 'server');
        $this->unifiUser = env('UNIFI_USER', 'username');
        $this->unifiPassword = env('UNIFI_PASSWORD', 'password');
    }

    public function index()
    {
        $data = collect([]); // Could also be an array
        $labels = collect([]);

        for ($days_backwards = 6; $days_backwards >= 0; --$days_backwards) {
            // Could also be an array_push if using an array rather than a collection.
            $data->push(AccessLog::whereDate('created_at', today()->subDays($days_backwards))->count());
            $labels->push(today()->subDays($days_backwards)->toFormattedDateString());
        }

        $weekly = new WifiUsage();
        $weekly->labels($labels);
        $weekly->dataset('Last 7 Days', 'bar', $data)->options([
            'color' => '#f6bb42',
            'backgroundColor' => '#4a89dc',
            'lineTension' => 0.5,
        ]);

        $recents = AccessLog::with(['user'])->latest()->take(10)->get();

        return view('network.wifi.index', compact('weekly', 'recents'));
    }

    public function login(Request $request)
    {
        // Check if User Credentials exists in Database
        $user = User::where('username', $request->username)->first();

        if ($user != null) {
            // Check if Password Matches
            $check = Hash::check($request->password, $user->password);
            if ($check == true) {
                // Set Current Timestamp
                $now = Carbon::now();

                // Set Minutes based on User Type
                if ($user->types[0]['name'] == 'Student') {
                    $minutes = 120; // 2 Hours
                } elseif ($user->types[0]['name'] == 'Faculty') {
                    $minutes = 600; // 10 Hours
                } elseif ($user->types[0]['name'] == 'Guest') {
                    $minutes = 60;
                } else {
                    $minutes = 10080; // 1 week
                }

                // Check if unexpired Log exists
                $log = $user->access_logs()->where('expires_on', '>', $now)->latest()->first();

                try {
                    if ($log != null) {
                        if ($log->device != $request->mac) {
                            // Unauthorize the other device
                            $state = $this->unauthorizeDevice($log->device);
                            // Authorize the new device
                            if ($state == true) {
                                $expiry = $now->addMinutes($minutes);
                                $newlog = $user->access_logs()->create([
                                    'device' => $request->mac,
                                    'ip' => $request->ip,
                                    'expires_on' => $expiry,
                                    'url' => $request->url,
                                ]);

                                return $this->sendAuthorization($newlog->device, $minutes);
                            }
                        }

                        return $this->sendAuthorization($request->mac, $minutes);
                    } else {
                        $expiry = $now->addMinutes($minutes);
                        $log = $user->access_logs()->create([
                            'device' => $request->mac,
                            'ip' => $request->ip,
                            'expires_on' => $expiry,
                            'url' => $request->url,
                        ]);

                        return $this->sendAuthorization($log->device, $minutes);
                    }
                } catch (Exception $ex) {
                    return $ex;
                }
            }

            return response()->json('Sign In Failed. Please Check your Username and Password', 404);
        }

        return response()->json('Sign In Failed. Please Check your Username and Password', 404);
    }

    public function checkAuthorization(Request $request)
    {
        $now = Carbon::now();

        $log = AccessLog::where('device', '=', $request->mac)->where('expires_on', '>', $now)->first();

        if ($log != null) {
            $remaining = now()->diffInRealMinutes($log->expires_on);

            return $this->sendAuthorization($log->device, $remaining);
        }

        return response()->json(['message' => 'Authorization Expired. Login Again'], 500);
    }

    public function sendAuthorization($id, $minutes)
    {
        // Initialize cURL
        $ch = curl_init();

        // Return Output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Post Data
        curl_setopt($ch, CURLOPT_POST, true);

        // Set up Cookies (or Biscuits)
        $cookie_file = '/tmp/unifi_cookie';
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

        // Allow Self-signed Certificates
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);

        // Login to UniFi Controller
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/api/login');

        $payload = json_encode([
            'username' => $this->unifiUser,
            'password' => $this->unifiPassword,
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);

        // Send User to authorize and the time allowed
        $data = json_encode([
            'cmd' => 'authorize-guest',
            'mac' => $id,
            'minutes' => $minutes,
        ]);

        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/api/s/default/cmd/stamgr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json='.$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);

        // Logout of the Connection
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/logout');
        curl_exec($ch);
        curl_close($ch);

        sleep(10);

        return response()->json('Success', 200);
    }

    public function unauthorizeDevice($id)
    {
        // Initialize cURL
        $ch = curl_init();

        // Return Output
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Post Data
        curl_setopt($ch, CURLOPT_POST, true);

        // Set up Cookies (or Biscuits)
        $cookie_file = '/tmp/unifi_cookie';
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

        // Allow Self-signed Certificates
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);

        // Login to UniFi Controller
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/api/login');

        $payload = json_encode([
            'username' => $this->unifiUser,
            'password' => $this->unifiPassword,
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);

        // Send User to authorize and the time allowed
        $data = json_encode([
            'cmd' => 'unauthorize-guest',
            'mac' => $id,
        ]);

        // Make the API Call
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/api/s/default/cmd/stamgr');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'json='.$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($ch);

        // Logout of the Connection
        curl_setopt($ch, CURLOPT_URL, $this->unifiServer.'/logout');
        curl_exec($ch);
        curl_close($ch);

        return true;
    }
}
