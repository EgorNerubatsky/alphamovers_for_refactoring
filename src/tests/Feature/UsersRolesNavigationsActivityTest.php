<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersRolesNavigationsActivityTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();


        $this->managerUser = User::factory()->create([
            'is_manager' => true,
            'password' => Hash::make('12345678'),
        ]);

        $this->executiveUser = User::factory()->create([
            'is_executive' => true,
            'password' => Hash::make('12345678'),
        ]);

        $this->hrUser = User::factory()->create([
            'is_hr' => true,
            'password' => Hash::make('12345678'),
        ]);

        $this->logistUser = User::factory()->create([
            'is_logist' => true,
            'password' => Hash::make('12345678'),
        ]);

        $this->accountantUser = User::factory()->create([
            'is_accountant' => true,
            'password' => Hash::make('12345678'),
        ]);
    }

    public function test_welcome_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_user_login_page()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }


    public function test_user_authenticate_using_the_correct_login(): void
    {
        $response = $this->post('/login', [
            'email' => $this->managerUser->email,
            'password' => '12345678',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/ERP/manager/leads');
    }

    public function test_user_logout_page(): void
    {
        $this->actingAs($this->managerUser);

        $response = $this->post(route('logout'));
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function test_user_authenticate_using_the_incorrect_password(): void
    {
        $response = $this->post('/login', [
            'email' => $this->managerUser->email,
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(302);
        $this->assertGuest();
    }

    public function test_user_authenticate_using_the_incorrect_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'managerr@local.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(302);
        $this->assertGuest();

    }

    public function test_user_following_the_link_without_role(): void
    {

        $this->managerUser->is_manager = false;
        $this->managerUser->save();

        $response = $this->actingAs($this->managerUser)->assertAuthenticated();
        $response->get('/ERP/manager/leads')->assertStatus(404);

    }

    public function test_user_redirect_to_login_without_role(): void
    {
        $this->managerUser->is_manager = false;
        $this->managerUser->save();

        $response = $this->post('/login', [
            'email' => $this->managerUser->email,
            'password' => '12345678',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_manager_leads_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'leads', 'index');
    }

    public function test_manager_orders_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'orders', 'index');
    }

    public function test_manager_clients_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'clients', 'index');
    }

    public function test_manager_finances_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'finances', 'index');
    }

    public function test_manager_report_view(): void
    {
        $response = $this->actingAs($this->managerUser)->get(route('erp.manager.report'));
        $response->assertStatus(200);
        $response->assertViewIs('erp.parts.finances.report');
    }

    public function test_manager_tasks_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'tasks', 'index');
    }

    public function test_manager_mail_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'emails', 'index');
    }

    public function test_manager_messages_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'messages', 'index');
    }

    public function test_manager_articles_view(): void
    {
        $this->routePagesView($this->managerUser, 'manager', 'articles', 'index');
    }

    public function test_manager_try_employees_view(): void
    {
        $this->inaccessiblePageView($this->managerUser, 'manager', 'employees', 404);
    }

    public function test_manager_try_movers_view(): void
    {
        $this->inaccessiblePageView($this->managerUser, 'manager', 'movers', 404);
    }

    public function test_manager_try_applicants_view(): void
    {
        $this->inaccessiblePageView($this->managerUser, 'manager', 'applicants', 404);
    }

    public function test_manager_try_arrears_view(): void
    {
        $this->inaccessiblePageView($this->managerUser, 'manager', 'arrears', 404);
    }

    public function test_manager_try_interviewees_view(): void
    {
        $this->inaccessiblePageView($this->managerUser, 'manager', 'interviewees', 404);
    }

    public function test_logist_orders_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'orders', 'index_logist');
    }

    public function test_logist_movers_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'movers', 'index');
    }


    public function test_logist_tasks_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'tasks', 'index');
    }

    public function test_logist_mail_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'emails', 'index');
    }

    public function test_logist_messages_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'messages', 'index');
    }

    public function test_logist_articles_view(): void
    {
        $this->routePagesView($this->logistUser, 'logist', 'articles', 'index');
    }


    public function test_logist_try_employees_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'employees', 404);
    }

    public function test_logist_try_finances_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'finances', 404);
    }

    public function test_logist_try_clients_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'clients', 404);
    }

    public function test_logist_try_leads_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'leads', 404);
    }

    public function test_logist_try_applicants_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'applicants', 404);
    }

    public function test_logist_try_arrears_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'arrears', 404);
    }

    public function test_logist_try_interviewees_view(): void
    {
        $this->inaccessiblePageView($this->logistUser, 'logist', 'interviewees', 404);
    }


    public function test_accountant_orders_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'orders', 'index_accountant');
    }

    public function test_accountant_clients_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'clients', 'index');
    }

    public function test_accountant_finances_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'finances', 'index');
    }
    public function test_accountant_arrears_view(): void
    {
//        $this->routePagesView($this->accountantUser, 'accountant', 'arrears', 'index');

        $response = $this->actingAs($this->accountantUser)->get(route('erp.accountant.arrears.index'));
        $response->assertStatus(200);
        $response->assertViewIs('erp.parts.clients.arrear');
    }

    public function test_accountant_report_view(): void
    {
        $response = $this->actingAs($this->accountantUser)->get(route('erp.accountant.report'));
        $response->assertStatus(200);
        $response->assertViewIs('erp.parts.finances.report');
    }

    public function test_accountant_tasks_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'tasks', 'index');
    }

    public function test_accountant_mail_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'emails', 'index');
    }

    public function test_accountant_messages_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'messages', 'index');
    }

    public function test_accountant_articles_view(): void
    {
        $this->routePagesView($this->accountantUser, 'accountant', 'articles', 'index');
    }

    public function test_accountant_try_employees_view(): void
    {
        $this->inaccessiblePageView($this->accountantUser,'accountant', 'employees', 404);
    }

    public function test_accountant_try_movers_view(): void
    {
        $this->inaccessiblePageView($this->accountantUser,'accountant', 'movers', 404);
    }

    public function test_accountant_try_applicants_view(): void
    {
        $this->inaccessiblePageView($this->accountantUser,'accountant', 'applicants', 404);
    }

    public function test_accountant_try_interviewees_view(): void
    {
        $this->inaccessiblePageView($this->accountantUser,'accountant', 'interviewees', 404);
    }


    public function test_hr_applicants_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'applicants', 'index');
    }

    public function test_hr_interviewees_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'interviewees', 'index');
    }


    public function test_hr_tasks_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'tasks', 'index');
    }

    public function test_hr_mail_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'emails', 'index');
    }

    public function test_hr_messages_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'messages', 'index');
    }

    public function test_hr_articles_view(): void
    {
        $this->routePagesView($this->hrUser, 'hr', 'articles', 'index');
    }

    public function test_hr_try_arrears_view(): void
    {
        $this->inaccessiblePageView($this->hrUser, 'hr', 'arrears', 404);
    }

    public function test_hr_try_finances_view(): void
    {
        $this->inaccessiblePageView($this->hrUser, 'hr', 'finances', 404);
    }

    public function test_hr_try_clients_view(): void
    {
        $this->inaccessiblePageView($this->hrUser, 'hr', 'clients', 404);
    }

    public function test_hr_try_leads_view(): void
    {
        $this->inaccessiblePageView($this->hrUser, 'hr', 'leads', 404);
    }

    public function test_hr_try_orders_view(): void
    {
        $this->inaccessiblePageView($this->hrUser, 'hr', 'orders', 404);
    }


    public function test_executive_leads_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'leads', 'index');
    }

    public function test_executive_orders_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'orders', 'index');
    }

    public function test_executive_clients_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'clients', 'index');
    }

    public function test_executive_finances_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'finances', 'index');
    }

    public function test_executive_report_view(): void
    {
        $response = $this->actingAs($this->executiveUser)->get(route('erp.executive.report'));
        $response->assertStatus(200);
        $response->assertViewIs('erp.parts.finances.report');
    }

    public function test_executive_tasks_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'tasks', 'index');
    }

    public function test_executive_mail_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'emails', 'index');
    }

    public function test_executive_messages_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'messages', 'index');
    }

    public function test_executive_articles_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'articles', 'index');
    }

    public function test_executive_employees_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'employees', 'index');
    }

    public function test_executive_movers_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'movers', 'index');
    }

    public function test_executive_applicants_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'applicants', 'index');
    }

    public function test_executive_arrears_view(): void
    {
        $response = $this->actingAs($this->executiveUser)->get(route('erp.executive.arrears.index'));
        $response->assertStatus(200);
        $response->assertViewIs('erp.parts.clients.arrear');
    }

    public function test_executive_interviewees_view(): void
    {
        $this->routePagesView($this->executiveUser, 'executive', 'interviewees', 'index');
    }


    private function routePagesView($user, $routeUser, $routePath, $page): void
    {
        $response = $this->actingAs($user)->get(route("erp.$routeUser.$routePath.index"));
        $response->assertStatus(200);
        $response->assertViewIs("erp.parts.$routePath.$page");
    }

    private function inaccessiblePageView($user, $role, $viewPart, $status): void
    {
        $response = $this->actingAs($user)->get("/ERP/$role/$viewPart");
        $response->assertStatus($status);
    }

}
