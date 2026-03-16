<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $user;
    public $isClient;

    public $agentCode;

    
    public function mount()
    {
        // Carregar o usuário autenticado
        $this->user = Auth::user();
    
        $this->isClient = !$this->user->is_admin && !$this->user->easy_id;

        $this->agentCode = $this->user->easy_id;
        
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
