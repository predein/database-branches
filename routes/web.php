<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Branch;

Route::get('/switch', function (Request $request) {
    $branch_id = $request->query('branch_id');
    if ($branch_id !== null) {
        $request->session()->put('branch_id', (int)$branch_id);
    }
    return redirect()->back(fallback: '/');
});

Route::get('/', function (Request $request) {
    $branches = App\Models\Branch::query()->latest()->get();
    Branch\Context::put($request->session()->get('branch_id'));
    $items = App\Models\Item::on(Branch\Context::connectionName())->latest('id')->get();
    return view('items', ['branches' => $branches, 'items' => $items, 'path' => '']);
})->name('items.index');

Route::get('/items/add', function (Request $request) {
    Branch\Context::put($request->session()->get('branch_id'));
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
    Branch\Context::put($request->session()->get('branch_id'));
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);
    $item = App\Models\Item::on('mysql')->create($data);
    return redirect()->route('items.index')->with('status', 'Created ID ' . $item->id);
})->name('items.create');

Route::get('/items/{id}/edit', function (Request $request, int $id) {
    Branch\Context::put($request->session()->get('branch_id'));
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
    Branch\Context::put($request->session()->get('branch_id'));
    $data = $request->validate([
        'title'   => ['required','string','max:255'],
        'content' => ['nullable','string'],
    ]);

    $item = App\Models\Item::on('mysql')->findOrFail($id);
    $item->fill($data)->save();

    return redirect()->route('items.index')->with('status', 'Updated ID ' . $item->id);
})->name('items.update');

