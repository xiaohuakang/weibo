<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * 关联用户模型
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
