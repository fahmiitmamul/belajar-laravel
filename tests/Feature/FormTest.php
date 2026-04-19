<?php

namespace Tests\Feature;

use Tests\TestCase;

class FormTest extends TestCase
{
    public function test_form()
    {
        $this->view('form', ['user' => [
            'premium' => true,
            'name' => 'Eko',
            'admin' => true,
        ]])
            ->assertSee('checked')
            ->assertSee('Eko')
            ->assertDontSee('readonly');

        $this->view('form', ['user' => [
            'premium' => false,
            'name' => 'Eko',
            'admin' => false,
        ]])
            ->assertDontSee('checked')
            ->assertSee('Eko')
            ->assertSee('readonly');
    }

    public function test_login_success()
    {
        $this->post('/form/login', [
            'username' => 'admin',
            'password' => 'rahasia',
        ])
            ->assertStatus(200);
    }

    public function test_login_failed()
    {
        $this->post('/form/login', [
            'username' => '',
            'password' => 'rahasia',
        ])
            ->assertStatus(400)
            ->assertSee('username is required');
    }
}
