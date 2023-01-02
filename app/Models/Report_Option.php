<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report_Option extends Model
{
    protected $table = 'report_option';

    public $timestamps = false;

    public function reports(){
        return $this->belongsToMany(Report::class,'report_reasons','id_report_option');
    }

    public static function auctionOptions(){
        return DB::table('report_option')->limit(9);
    }

    public static function userOptions(){
        return DB::table('report_option')
                ->where('id', 10)
                ->orWhere('id', 11);
    }
}
