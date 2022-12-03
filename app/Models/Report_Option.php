<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_Option extends Model
{
    protected $table = 'report_option';

    public $timestamps = false;
    // use HasFactory;

    public function reports(){
        return $this->belongsToMany(Report::class,'report_reasons','id_report_option');
    }
}
