<?php

use Illuminate\Support\Facades\Route;
use App\Branch;

Route::get('/', function () {
    $items = App\Models\Item::all();
    return view('items', ['items' => $items]);
});

Route::get('/add', function () {
    $itemFactory = App\Models\Item::factory();
    $item = $itemFactory->createOne(
        [
            'title' => md5(microtime()),
            'content' => '_content_',
        ],
    );
    return "Added " . $item->getAttributes()['title'];
});

Route::get('/branch/123', function () {
    Branch\Context::put(123);
    $items = App\Models\Item::all();
    return view('items', ['items' => $items]);
});

Route::get('/branch/123/add', function () {
    Branch\Context::put(123);
    $itemFactory = App\Models\Item::factory();
    $item = $itemFactory->state(
        [
            'title' => md5(microtime()),
            'content' => '_content_',
        ],
    )->make();
    $item->save();
    return "Added in branch" . $item->getAttributes()['title'];
});
