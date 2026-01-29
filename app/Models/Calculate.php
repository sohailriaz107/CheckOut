<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculate extends Model
{
    use HasFactory;


    public static function dateConvertion($date)
    {
        $d = explode('-', $date);
        $date = $d[2] . '-' . $d[0] . '-' . $d[1];
        return $date;
    }
}
