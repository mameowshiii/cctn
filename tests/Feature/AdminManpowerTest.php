<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Manpower;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminManpowerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Create an administrator for tests
        $this->admin = Admin::create([
            'fullname' => 'Test Administrator',
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role'     => 'super_admin',
        ]);
    }

    public function test_guest_cannot_view_manpower_page()
    {
        $response = $this->get(route('admin.manpower'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_manpower_list()
    {
        // Pre-create some manpower members
        Manpower::create([
            'name'         => 'Rico Villanueva',
            'role'         => 'Fiber Technician',
            'availability' => 'Available',
            'notes'        => 'Coordinates maintenance schedules',
        ]);

        // Authenticate admin
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.manpower'));

        $response->assertStatus(200);
        $response->assertViewHas('staff');
        $response->assertSee('Rico Villanueva');
        $response->assertSee('Fiber Technician');
    }

    public function test_admin_can_add_manpower_member()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.manpower.store'), [
                'name'         => 'John Dela Cruz',
                'role'         => 'Field Specialist',
                'availability' => 'Busy',
                'notes'        => 'Heavy cabling expert',
            ]);

        $response->assertRedirect(route('admin.manpower'));
        $response->assertSessionHas('success_message', 'Staff member added.');

        $this->assertDatabaseHas('manpower', [
            'name'         => 'John Dela Cruz',
            'role'         => 'Field Specialist',
            'availability' => 'Busy',
            'notes'        => 'Heavy cabling expert',
        ]);
    }

    public function test_admin_can_update_manpower_status()
    {
        $crew = Manpower::create([
            'name'         => 'Maria Santos',
            'role'         => 'Customer Support',
            'availability' => 'Available',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.manpower.update_status'), [
                'crew_id'      => $crew->id,
                'availability' => 'Off Duty',
            ]);

        $response->assertRedirect(route('admin.manpower'));
        $response->assertSessionHas('success_message', 'Status updated.');

        $this->assertDatabaseHas('manpower', [
            'id'           => $crew->id,
            'availability' => 'Off Duty',
        ]);
    }
}
