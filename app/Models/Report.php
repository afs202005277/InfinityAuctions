<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    protected $table = 'report';

    public $timestamps = false;

    public function reporter(){
        return $this->belongsTo(User::class, 'reporter');
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function reportOptions(){
        return $this->belongsToMany(Report_Option::class,'report_reasons','id_report','id_report_option');
    }

    public function reportedUser(){
        return $this->belongsTo(User::class, 'reported_user');
    }

    public function reportedAuction(){
        return $this->belongsTo(Auction::class, 'auction_reported');
    }

    public function handledBy(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function handleReport(Request $request) {

    }

    public static function getEvaluator() {
        $assignedAdmins = DB::select(DB::raw(
            'SELECT users.id AS "id"
            FROM (SELECT users.id
                  FROM users
                  WHERE users.is_admin = \'true\') AS "users"
            INNER JOIN report ON report.admin_id = users.id
            GROUP BY users.id
            ORDER BY COUNT(users.id) ASC;'
        ));
        
        $admins = DB::select(DB::raw(
            'SELECT users.id AS id
            FROM users
            WHERE users.is_admin = \'true\''
        ));

        $assigAdminsArray = array_column($assignedAdmins, 'id');
        $diff = array_diff(array_column($admins, 'id'), $assigAdminsArray);

        if( !empty($diff) ){
            $id = $diff[0];
            return $id;
        }
        
        $id = $assigAdminsArray[0];
        return $id;
    }
}
