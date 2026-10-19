<?php

namespace Tests\Feature;

use App\Livewire\Admin\Profile;
use App\Livewire\Site\Contact;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
        $this->assertSame('projects/market-pilot.png', Project::query()->where('slug', 'market-pilot')->value('icon_path'));
        $this->assertTrue(Storage::disk('public')->exists('brand/logo.jpg'));
        $this->assertTrue(Storage::disk('public')->exists('projects/market-pilot.png'));
        $this->assertTrue(Storage::disk('public')->exists('projects/pro4home.svg'));
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
            ->assertRedirect(route('contact.sent', ['locale' => 'en']));

        $this->get('/en/contact/sent')
            ->assertOk()
            ->assertSee('Your message has been sent.');

        $this->get('/en/contact/sent')->assertRedirect('/en/contact');

        Mail::assertSent(ContactMessageMail::class, function ($mail) {
            return $mail->hasTo('djforbian@gmail.com');
        });
    }

    public function test_a_new_portrait_replaces_the_picture_on_the_site(): void
    {
        $this->seed();
        Storage::fake('public');
        Storage::disk('public')->put('brand/portrait.jpg', 'old-portrait');

        $user = User::query()->where('email', 'djforbian@gmail.com')->first();

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('portrait', UploadedFile::fake()->image('face.jpg', 40, 50))
            ->assertHasNoErrors();

        $path = Setting::query()->value('portrait_path');

        $this->assertNotSame('brand/portrait.jpg', $path);
        $this->assertTrue(Storage::disk('public')->exists($path));
        $this->assertFalse(Storage::disk('public')->exists('brand/portrait.jpg'));
        $this->get('/en')->assertSee('media/'.$path, false);
        $this->get('/en/about')->assertSee('media/'.$path, false);
        $this->get('/en/cv')->assertSee('media/'.$path, false);
        $this->get('/media/'.$path)->assertOk();
    }
}
