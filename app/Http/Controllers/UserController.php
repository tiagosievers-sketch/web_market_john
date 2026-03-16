<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Adicione o uso do Auth

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $this->listUsers($request);
    }

    // Método para listar usuários
    public function listUsers(Request $request)
    {
        $builder = User::orderBy('name', 'asc');
        $user_id = Auth::id();
        $user = User::find($user_id);

        if (isset($user->is_admin) && !$user->is_admin) {
            $builder->where('id', '=', $user_id);
        }

        // Retorna uma coleção de usuários
        return response()->json($builder->get());
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image_pdf' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image_pdf')) {
            // Exclui a imagem antiga, se existir
            if ($user->profile_image_pdf && Storage::disk('public')->exists($user->profile_image_pdf)) {
                Storage::disk('public')->delete($user->profile_image_pdf);
            }

            // Armazena a nova imagem e salva o caminho no banco de dados
            $path = $request->file('profile_image_pdf')->store('profile_images', 'public');
            $user->profile_image_pdf = $path;
        }

        $user->save();

        return back()->with('success', __('labels.profileUpdated'));
    }

    public function deleteImage()
    {
        try {
            $user = auth()->user();
    
            if ($user->profile_image_pdf && Storage::disk('public')->exists($user->profile_image_pdf)) {
                Storage::disk('public')->delete($user->profile_image_pdf);
                $user->profile_image_pdf = null;
                $user->save();
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
