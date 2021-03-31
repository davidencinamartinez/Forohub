<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class FailedAuthAttempt extends Model {
    use HasFactory;

    protected $fillable = [
        'created_at',
        'updated_at',
        'ip_address'
    ];

    protected $table = 'failed_auth_attempts';

    public function attempts() {
    	return $this->whereBetween('created_at', [Carbon::now()->subMinutes(10), Carbon::now()]);
    }

    public static function createFailedAuthAttempt($request) {
    	$ip = User::getClientIPAddress($request);
    	FailedAuthAttempt::create([
    		'ip_address' => $ip
    	]);
    }
}
