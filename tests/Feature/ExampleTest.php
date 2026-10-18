<?php

namespace Tests\Feature;

use App\Livewire\Site\Contact;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_and_contact(): void
    {
        $this->seed();

        $this->get('/')->assertRedirect('/en');
        $this->get('/en')->assertOk()->assertSee('Ivanotechs')->assertSee('Yannick Ivan Djoukeng Nougning');
        $this->get('/de/cv')->assertOk()->assertSee('Afrovision');
        $this->get('/fr/projects')->assertOk();
        $this->get('/en/projects/market-pilot')->assertOk()->assertSee('mk.funvas.com');
        $this->get('/sitemap.xml')->assertOk();
        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap:');
        $this->get('/en/admin')->assertRedirect('/en/admin/login');

        $user = User::query()->where('email', 'djforbian@gmail.com')->first();
        $this->assertNotNull($user);
        $this->actingAs($user)->get('/en/admin')->assertOk();

        ContactMessage::query()->create([
            'name' => 'Ada',
            'email' => 'ada@example.com',
            'subject' => 'Hello',
            'body' => 'A note',
            'locale' => 'en',
        ]);

        $this->assertDatabaseHas('contact_messages', ['email' => 'ada@example.com']);

        Mail::fake();
        Livewire::test(Contact::class)
            ->set('name', 'Ada')
            ->set('email', 'ada@example.com')
            ->set('subject', 'A project')
            ->set('message', 'Hello from the form')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('sent', true);

        Mail::assertSent(\App\Mail\ContactMessageMail::class, function ($mail) {
            return $mail->hasTo('djforbian@gmail.com');
        });
    }
}
