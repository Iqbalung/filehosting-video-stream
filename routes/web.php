<?php

use App\Http\Controllers\Dashboard\DirectoryController;
use App\Http\Controllers\Dashboard\HomeController as DashboardController;
use App\Http\Controllers\Dashboard\FilesController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\StorageUrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("welcome");
});

Route::group(
    [
        "middleware" => ["auth:sanctum", "verified"],
        "as" => "dashboard.",
        "prefix" => "/dashboard",
    ],
    function () {
        Route::get("/", DashboardController::class)->name("index");

        Route::get("/xfiles/datatable", [
            FilesController::class,
            "ajaxDataTable",
        ])->name("files.dataTable");

        Route::resource("/files", FilesController::class);
        Route::resource("/register", FilesController::class);
        Route::get("/directory", [DirectoryController::class, "index"])->name(
            "directory.index"
        );
        Route::post("/directory", [DirectoryController::class, "store"])->name(
            "directory.store"
        );
        Route::post("/directory/edit", [
            DirectoryController::class,
            "edit",
        ])->name("directory.edit");
        Route::post("/directory/update", [
            DirectoryController::class,
            "update",
        ])->name("directory.update");
        Route::delete("/directory/", [
            DirectoryController::class,
            "delete",
        ])->name("directory.delete");
    }
);

Route::get("/embed/{code}", [EmbedController::class, "show"])->name(
    "embed-show"
);
Route::get("/show/{code}", [ShowController::class, "show"])->name("file-show");
Route::get("/view/{code}", [ShowController::class, "download"])->name(
    "file-download"
);
Route::get("/storage-url", StorageUrlController::class)->name("storage-url");
Route::get("/register-new", [ShowController::class, "register_new"])->name(
    "register-new"
);
Route::get("/delete/{id}", [FilesController::class, "delete"])->name("delete");
Route::get("/search", [FilesController::class, "search"]);

//
//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return view('dashboard');
//})->name('dashboard');
