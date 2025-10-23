<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class Register extends Component
{
    #[Validate('required|min:5')]
    public $username = '';

    #[Validate('required|min:5')]
    public $password = '';

    public function save()
    {
        $this->validate();

        User::create([
            'username' => $this->username,
            'password' => Hash::make($this->password), // lebih baik pakai Hash::make()
        ]);

        session()->flash('success', 'Account created successfully!');

        return redirect()->route('login');

    }

    public function render()
    {
        return view('livewire.register');
    }
}
