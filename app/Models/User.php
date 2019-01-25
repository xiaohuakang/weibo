<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 关联微博动态模型
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 关联粉丝模型
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }


    /**
     * 关注用户操作
     * @param $user_ids 用户id
     */
    public function follow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注操作
     * @param $user_ids 用户id
     */
    public function unfollow($user_ids)
    {
        if ( ! is_array($user_ids)) {
            $user_ids = compact($user_ids);
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断是否已关注
     * @param $user_id 用户id
     * @return mixed
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }




    /**
     * 获取 gravatar 头像
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 模型初始化后执行方法
     */
    public static function boot()
    {
        parent::boot();
        // 生成用户激活 token
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }


    /**
     * 获取用户发布的所有微博
     */
    public function feed()
    {
        return $this->statuses()->orderBy('created_at', 'desc');
    }


}
