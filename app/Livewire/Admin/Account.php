<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Account extends Page
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $city = '';

    public string $country = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $saved = false;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = (string) $user->phone;
        $this->address = (string) $user->address;
        $this->city = (string) $user->city;
        $this->country = (string) $user->country;
    }

    public function save(): void
    {
        $user = Auth::user();

        $this->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:160', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->city = $this->city;
        $user->country = $this->country;

        if ($this->password !== '') {
            $user->password = $this->password;
        }

        $user->save();
        $this->reset('password', 'password_confirmation');
        $this->saved = true;
    }

    protected function viewName(): string
    {
        return 'livewire.admin.account';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.nav.account').' — Ivanotechs';
    }
}
