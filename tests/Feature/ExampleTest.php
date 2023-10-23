<?php

declare(strict_types=1);

it('the application returns a successful response', function (): void {
    $response = $this->get('/');
    $response->assertStatus(200);
});
