<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

abstract class AbstractModel extends Model
{
    use HasFactory;

    protected static function booting(): void
    {

        parent::booting();

        static::creating(function ($classModel) {
            if($user = Auth::user()){
                if(array_key_exists( 'created_by', $classModel->getAttributes())){
                    $classModel->created_by = $user->getAuthIdentifier();
                }
                if(array_key_exists( 'updated_by', $classModel->getAttributes())){
                    $classModel->updated_by = $user->getAuthIdentifier();
                }
            }
        });

        static::updating(function ($classModel) {
            if($user = Auth::user()){
                if(array_key_exists( 'updated_by', $classModel->getAttributes())){
                    $classModel->updated_by = $user->getAuthIdentifier();
                }
            }
        });

        static::deleting(function ($classModel) {
            if($user = Auth::user()){
                if(array_key_exists( 'deleted_by', $classModel->getAttributes())){
                    $classModel->deleted_by = $user->getAuthIdentifier();
                    $classModel->save();
                }
            }
        });
    }
}
