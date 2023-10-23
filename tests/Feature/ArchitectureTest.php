<?php

declare(strict_types=1);

use Illuminate\Http\Request;

test('ensures no debugging')
    ->expect(['dd', 'dump', 'ray', 'var_dump'])
    ->not->toBeUsed();

test('enforces form request')
    ->expect('\App\Http\Controllers')
    ->not->toUse(Request::class);

test('ensures tests strict classes and suffix')
    ->expect('App')
    ->toUseStrictTypes()
    ->and('Tests')
    ->toUseStrictTypes()
    ->and('Tests\Feature')->toHaveSuffix('Test')
    ->and('Tests\Unit')->toHaveSuffix('Test');

test('ensure actions only on controllers, jobs, and models')
    ->expect('\App\Actions')
    ->toOnlyBeUsedIn('\App\Http\Controllers')
    ->toOnlyUse(['\App\Jobs', '\App\Models']);
