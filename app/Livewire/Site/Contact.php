<?php

namespace App\Livewire\Site;

use App\Livewire\Page;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class Contact extends Page
{
    public string $name = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $sent = false;

    public function another(): void
    {
        $this->sent = false;
        $this->toast(__('site.toast.contact_another'), 'info');
    }

    public function submit(): void
    {
        $key = 'contact:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('message', __('site.contact.validation.throttle'));
            $this->toast(__('site.contact.validation.throttle'), 'error');

            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => __('site.contact.validation.name'),
            'email.required' => __('site.contact.validation.email'),
            'email.email' => __('site.contact.validation.email'),
            'subject.required' => __('site.contact.validation.subject'),
            'message.required' => __('site.contact.validation.message'),
        ]);

        $record = ContactMessage::query()->create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'body' => $this->message,
            'locale' => app()->getLocale(),
        ]);

        $to = Setting::current()?->public_email ?: config('mail.from.address');

        try {
            Mail::to($to)->send(new ContactMessageMail($record));
        } catch (\Throwable $exception) {
            report($exception);
        }

        RateLimiter::hit($key, 3600);
        $this->reset('name', 'email', 'subject', 'message');
        $this->sent = true;
        $this->toast(__('site.toast.contact_sent'));
    }

    protected function viewName(): string
    {
        return 'livewire.site.contact';
    }

    protected function pageKey(): ?string
    {
        return 'contact';
    }
}
