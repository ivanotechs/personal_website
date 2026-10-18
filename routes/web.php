<?php

use App\Http\Controllers\SeoController;
use App\Livewire\Admin\Account;
use App\Livewire\Admin\Branding;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Educations;
use App\Livewire\Admin\Experiences;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\Messages;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\ProjectForm;
use App\Livewire\Admin\ProjectIndex;
use App\Livewire\Admin\Skills;
use App\Livewire\Admin\Themes;
use App\Livewire\Site\About;
use App\Livewire\Site\Contact;
use App\Livewire\Site\Cv;
use App\Livewire\Site\Home;
use App\Livewire\Site\Projects;
use App\Livewire\Site\ProjectShow;
use App\Support\LocaleResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [SeoController::class, 'robots']);
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);

Route::get('/', function (Request $request) {
    $locale = $request->cookie('locale');

    if (! in_array($locale, LocaleResolver::ALL, true)) {
        $locale = app(LocaleResolver::class)->resolve($request);
    }

    return redirect()
        ->route('home', ['locale' => $locale])
        ->withCookie(cookie('locale', $locale, 60 * 24 * 365));
});

Route::prefix('{locale}')
    ->whereIn('locale', LocaleResolver::ALL)
    ->middleware('locale')
    ->group(function () {
        Route::get('/', Home::class)->name('home');
        Route::get('/about', About::class)->name('about');
        Route::get('/cv', Cv::class)->name('cv');
        Route::get('/projects', Projects::class)->name('projects');
        Route::get('/projects/{project}', ProjectShow::class)->name('projects.show')->where('project', '[a-z0-9\-]+');
        Route::get('/contact', Contact::class)->name('contact');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/login', Login::class)->name('login')->middleware('guest');

            Route::middleware('auth')->group(function () {
                Route::get('/', Dashboard::class)->name('dashboard');
                Route::get('/profile', Profile::class)->name('profile');
                Route::get('/account', Account::class)->name('account');
                Route::get('/branding', Branding::class)->name('branding');
                Route::get('/themes', Themes::class)->name('themes');
                Route::get('/experience', Experiences::class)->name('experience');
                Route::get('/education', Educations::class)->name('education');
                Route::get('/skills', Skills::class)->name('skills');
                Route::get('/projects', ProjectIndex::class)->name('projects.index');
                Route::get('/projects/create', ProjectForm::class)->name('projects.create');
                Route::get('/projects/{project}/edit', ProjectForm::class)->name('projects.edit');
                Route::get('/messages', Messages::class)->name('messages');
                Route::post('/logout', function () {
                    auth()->logout();
                    request()->session()->invalidate();
                    request()->session()->regenerateToken();

                    return redirect()->route('admin.login', ['locale' => app()->getLocale()]);
                })->name('logout');
            });
        });
    });
