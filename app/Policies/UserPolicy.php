<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 更新用户信息策略
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 删除用户信息策略
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin &&  $currentUser->id !== $user->id;
    }


    // 关注用户授权策略
    public function follow (User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }

}
