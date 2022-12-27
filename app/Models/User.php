<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    public function getEmailForPasswordReset(){
        return $this->email;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'gender', 'cellphone', 'email', 'birth_date', 'address', 'password', 'rate', 'credits', 'wishlist', 'is_admin', 'profile_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(Wishlist::class, 'users_wishlist', 'users_id');
    }

    public function followingAuctions()
    {
        return $this->belongsToMany(Auction::class, 'following');
    }

    public function ownedToBeStartedAuctions(){
        return $this->ownedAuctions()->where('state', '=','To be started');
    }

    public function ownedRunningAuctions(){
        return $this->ownedAuctions()->where('state','=','Running');
    }

    public function ownedAuctions()
    {
        return $this->hasMany(Auction::Class, 'auction_owner_id');
    }

    public function biddingAuctions($user_id)
    {
        return DB::table('bid')
        ->join('auction', 'bid.auction_id', '=', 'auction.id')
        ->where('bid.user_id', '=', $user_id)
        ->select('auction.*')
        ->distinct()
        ->get();
    }

        
    public function wonAuctions()
    {
        $array = [];
        $bidding = $this->biddingAuctions($this->id);
        foreach($bidding as $auction) {
            $maxAmount = $auction->bids()->max('amount');
            $winnerId = $auction->bids()->where('amount', $maxAmount)->value('user_id');
            if($this->id == $winnerId){
                array_push($array, $auction);
            }
        }

        return $array;
    }


    public function reportsMade()
    {
        return $this->hasMany(Report::class, 'reporter');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function wasReported()
    {
        return $this->hasMany(Report::class, 'reported_user');
    }

    public function reportsHandled()
    {
        return $this->hasMany(Report::class, 'admin_id');
    }

    public function profileImage(){
        return $this->belongsTo(Image::class, 'profile_image');
    }

    public function isBanned()
    {
        $reports = $this->wasReported()->get();
        foreach ($reports as $report) {
            if ($report->penalty == 'Banned for life')
                return true;
            if ($report->penalty == '3 day ban' && strtotime(date_add($report->date, date_interval_create_from_date_string("3 days"))) >= date('Y-m-d H:i:s')) {
                return true;
            }
            if ($report->penalty == '5 day ban' && strtotime(date_add($report->date, date_interval_create_from_date_string("5 days"))) >= date('Y-m-d H:i:s')) {
                return true;
            }
            if ($report->penalty == '10 day ban' && strtotime(date_add($report->date, date_interval_create_from_date_string("10 days"))) >= date('Y-m-d H:i:s')) {
                return true;
            }
            if ($report->penalty == '1 month ban' && strtotime(date_add($report->date, date_interval_create_from_date_string("1 months"))) >= date('Y-m-d H:i:s')) {
                return true;
            }
        }
        return false;
    }

    // retorna todos os users que avaliaram o user atual
    public function rate_bidders(){
        return $this->belongsToMany(User::class, 'rates', 'id_seller', 'id_bidder');
    }

    // retorna todos os users avaliados pelo current user
    public function rate_sellers(){
        return $this->belongsToMany(User::class, 'rates', 'id_bidder', 'id_seller');
    }

    public function getRatingDetails(){
        return ["rate" => round($this->rate_bidders()->average('rate'), 2), "numberOfRatings" => $this->rate_bidders()->count()];
    }

    public function hasPendingMaxBids(){
        return DB::select(DB::raw('select has_max_bid(' . Auth::id() . ');'))[0];
    }

    public static function getUsersWithImages(){
        return DB::table('users')
            ->join('image', 'users.profile_image', '=', 'image.id')
            ->select('*');
    }
    
    public static function addBalance($id, $amount) {
        $user = User::find($id);
        $user->credits = User::getBalance($id)+$amount;
        return $user->save();
    }

    public static function removeBalance($id, $amount) {
        $user = User::find($id);
        $user->credits = User::getBalance($id)-$amount;
        return $user->save();
    }

    public static function getBalance($id) {
        return User::find($id)->credits;
    }

    public static function heldBalance($user_id) {
        $value = DB::select(DB::raw('SELECT SUM(max) 
                                    FROM (  SELECT BID.auction_id, BID.user_id, MAX(BID.amount) 
                                            FROM BID, AUCTION
                                            WHERE AUCTION.state = \'Running\'
                                            GROUP BY auction_id, user_id 
                                         ) top_bids 
                                    WHERE user_id = ' . $user_id . ' GROUP BY user_id;'));

        if (empty($value)) {
            return 0;
        }
        return $value[0]->sum;
    }
}
