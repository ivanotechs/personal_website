<?php

namespace App\Livewire\Admin;

use App\Livewire\Page;
use Illuminate\Support\Facades\Auth;

class Login extends Page
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public function submit(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('site.admin.login.failed'));

            return;
        }

        session()->regenerate();
        $this->redirectRoute('admin.dashboard', ['locale' => app()->getLocale()], navigate: true);
    }

    protected function viewName(): string
    {
        return 'livewire.admin.login';
    }

    protected function layout(): string
    {
        return 'layouts.admin';
    }

    protected function title(): string
    {
        return __('site.admin.login.title').' — Ivanotechs';
    }
}
