<?php
/**
 ***********************************
 * Created by PhpStorm
 * @author         Alan-wen
 * @created        2018/12/17 11:39*
 *
 ***********************************
 *
 * @$LastChangedBy:
 * @$LastChangedDate:
 * @$LastChangedRevision:
 * @$HeadURL:
 *
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login_name', 'email', 'password','qq_openid','avatar','nick_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



}
