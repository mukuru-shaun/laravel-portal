<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testDashboard()
    {
        User::factory()->create([
            'id' => 1,
            'email' => 'test@example.com',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->assertSee('Dashboard')
                ->assertSee('Update your public key')
                ->assertSee('Link your Github and Gitlab accounts');
        });
    }

    public function testDashboardLinks()
    {
        User::factory()->create([
            'id' => 1,
            'email' => 'test@example.com',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/')
                ->clickLink('Update your public key')
                ->assertUrlIs('http://laravel.test/profile');

            $browser->visit('/')
                ->clickLink('Link your Github and Gitlab accounts')
                ->assertUrlIs('http://laravel.test/external-accounts');
        });
    }
}
