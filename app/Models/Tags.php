<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{


    public static function StatusMap()
    {
        return $statusMap = [
            1 => 'javasrcipt',
            2 => 'java',
            3 => 'php',
            4 => 'go',
            5 => 'python',
        ];
    }

}
