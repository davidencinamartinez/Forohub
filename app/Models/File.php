<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model {

    use HasFactory;

    public static function uploadImage($file) {
    	
    	$upload = cloudinary()->upload($file->getRealPath())->getSecurePath();
    	dd($upload);
    }
}
