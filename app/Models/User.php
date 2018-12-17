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

class User extends Model
{
    protected $table = 'users';
    public function getUserInfo()
    {
        return $this->find(10);

    }


}