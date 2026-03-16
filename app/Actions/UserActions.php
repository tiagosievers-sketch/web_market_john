<?php

namespace App\Actions;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActions
{
    public static function listUsers(Request $request): UserCollection
    {
        $builder = User::orderBy('name', 'asc');
        $user_id = Auth::id();
        $user =  User::find($user_id);
        if(isset($user->is_admin)){
            if(! $user->is_admin){
                $builder->where('id', '=', $user_id);
            }
        }
        return new UserCollection(
            $builder->get()
        );
    }
}
