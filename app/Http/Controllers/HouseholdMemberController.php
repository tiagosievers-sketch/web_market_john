<?php

namespace App\Http\Controllers;

use App\Http\Resources\HouseholdMemberResource;
use App\Models\HouseholdMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HouseholdMemberController extends Controller
{
    /**
     * @throws \Exception
     */
    public function show(HouseholdMember $householdMember): HouseholdMemberResource
    {
        return new HouseholdMemberResource($householdMember);
    }
}
