<?php

test('successfully renders auth login page', function () {

    $response = $this->get(route('login'));

    $response->assertStatus(200);

    $response->assertInertia(fn ($page) =>
        $page->component('Auth/Login')
    );
});
