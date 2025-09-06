<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Branch;

Route::get('/', function () {
    $items = App\Models\Item::on('mysql')->latest('id')->get();
    return view('items', ['items' => $items, 'path' => '']);
})->name('items.index');

Route::get('/items/add', function () {
    $action = URL::route('items.create');
    $csrf = csrf_token();
    return view(
        'items_form',
        [
            'path' => '',
            'action' => $action,
            'csrf' => $csrf,
            'title' => '',
            'content' => '',
        ],
    );
})->name('items.form');

Route::post('/items/create', function (Request $request) {
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);
    $item = App\Models\Item::on('mysql')->create($data);
    return redirect()->route('items.index')->with('status', 'Created ID ' . $item->id);
})->name('items.create');

// Show edit form (main DB)
Route::get('/items/{id}/edit', function (int $id) {
    $item = App\Models\Item::on('mysql')->findOrFail($id);
    $action = URL::route('items.update', ['id' => $item->id]);
    $csrf   = csrf_token();
    $title = e($item->title);
    $content = e($item->content);

    return view(
        'items_form',
        [
            'path' => '',
            'action' => $action,
            'csrf' => $csrf,
            'title' => $title,
            'content' => $content,
        ],
    );
})->name('items.edit');

Route::post('/items/{id}', function (Request $request, int $id) {
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);

    $item = App\Models\Item::on('mysql')->findOrFail($id);
    $item->fill($data)->save();

    return redirect()->route('items.index')->with('status', 'Updated ID ' . $item->id);
})->name('items.update');

// Branch
Route::get('/branch/{branchId}', function (int $branchId) {
    Branch\Context::put($branchId);
    $items = App\Models\Item::on('branches')->latest('id')->get();
    return view('items', ['items' => $items, 'path' => '/branch/' . $branchId]);
})->name('branch.items.index');

Route::get('/branch/{branchId}/items/add', function (int $branchId) {
    Branch\Context::put($branchId);
    $action = URL::route('branch.items.create', ['branchId' => $branchId]);
    $csrf   = csrf_token();
    return view(
        'items_form',
        [
            'path' => '/branch/' . $branchId,
            'action' => $action,
            'csrf' => $csrf,
            'title' => '',
            'content' => '',
        ],
    );
})->name('branch.items.add');

Route::post('/branch/{branchId}/items', function (Request $request, int $branchId) {
    Branch\Context::put($branchId);
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);
    $item = App\Models\Item::query()->create($data);
    return redirect()->route('branch.items.index', ['branchId' => $branchId])
        ->with('status', 'Created ID '.$item->id.' in branch ' . $branchId);
})->name('branch.items.create');

Route::get('/branch/{branchId}/items/{id}/edit', function (int $branchId, int $id) {
    Branch\Context::put($branchId);
    $item = App\Models\Item::query()->findOrFail($id);
    $action = URL::route('branch.items.update', ['branchId' => $branchId, 'id' => $item->id]);
    $csrf   = csrf_token();
    $title = e($item->title);
    $content = e($item->content);

    return view(
        'items_form',
        [
            'path' => '/branch/' . $branchId,
            'action' => $action,
            'csrf' => $csrf,
            'title' => $title,
            'content' => $content,
        ],
    );
})->name('branch.items.edit');

Route::post('/branch/{branchId}/items/{id}', function (Request $request, int $branchId, int $id) {
    Branch\Context::put($branchId);
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);
    $item = App\Models\Item::on('branches')->findOrFail($id);
    $item->fill($data)->save();
    return redirect()->route('branch.items.index', ['branchId' => $branchId])
        ->with('status', 'Updated ID '.$item->id.' in branch '.$branchId);
})->name('branch.items.update');
