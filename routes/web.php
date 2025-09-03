<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/branch', function () {
    $items = App\Models\Item::on('branches')->get()->all();
    return view('items', ['items' => $items]);
});

Route::get('/branch/add', function () {
    $itemFactory = App\Models\Item::factory();
    $item = $itemFactory->state(
        [
            'title' => md5(microtime()),
            'content' => '_content_',
        ],
    )->make();
    $item->setConnection('branches');
    $item->save();
    return "Added in branch" . $item->getAttributes()['title'];
});
