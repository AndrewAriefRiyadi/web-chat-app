<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class Login extends Component
{
    #[Validate('required|min:5')]
    public $username = '';

    #[Validate('required')]
    public $password = '';

    public function save()
    {
        try {
            $this->validate();

            // Cari user berdasarkan username
            $user = User::where('username', $this->username)->first();

            if (!$user || !Hash::check($this->password, $user->password)) {
                // Jika gagal login
                session()->flash('error', 'Invalid username or password.');
                return;
            }
            Auth::login($user);
            session()->regenerate();
            // Beri pesan sukses
            session()->flash('success', 'Welcome back, ' . $user->username . '!');
            return redirect()->to('/home');
        } catch (\Throwable $th) {
            return redirect()->back();
        }



    }

    public function render()
    {
        return view('livewire.login');
    }
}
