<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\UserRepository;
use App\Models\User;
use App\Models\Role;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 清除原有用户组，加入新的用户组
     * @param $user_id int 用户ID
     * @param $role_id int 权限组ID
     * @return bool
     * */
    public function editUserRole($user_id, $role_id)
    {
        $user = $this->find($user_id);
        foreach($user->roles as $role) {
            $roles[] = $role->id;
        }
        $old_role = Role::findOrfail($roles[0]);
        $new_role = Role::findOrfail($role_id);
        // 删除原用户组
        $user->detachRole($old_role);
        $user->attachRole($new_role);
        if ($user->hasRole($new_role->name)) {
            return true;
        } else {
            return false;
        }
    }
}
