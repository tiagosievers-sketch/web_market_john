<?php

namespace App\Actions;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserProfileActions
{
    public static function addUserProfile(int $user_id, int $profile_id): bool
    {
        $userProfile = UserProfile::where('user_id',$user_id)->where('domain_value_id',$profile_id)->first();
        if(!($userProfile instanceof UserProfile)){
            $userProfileData = [
                'user_id' => $user_id,
                'domain_value_id'=> $profile_id
            ];
            $userProfile = UserProfile::create($userProfileData);
            if($userProfile instanceof UserProfile){
                return true;
            }
        }
        return false;
    }
    public static function removeUserProfile(int $user_id, int $profile_id): bool
    {
        $userProfile = UserProfile::where('user_id',$user_id)->where('domain_value_id',$profile_id)->first();
        if($userProfile instanceof UserProfile){
            return $userProfile->delete();
        }
        return false;
    }

    public static function verifyProfile(int $user_id, array $alias): bool
    {
        $userProfile = UserProfile::whereHas('profile', function (Builder $query) use ($alias) {
            $query->whereIn('alias', $alias);
        })->where('user_id',$user_id)->first();
        if($userProfile instanceof UserProfile){
            return true;
        }
        return false;
    }
}
