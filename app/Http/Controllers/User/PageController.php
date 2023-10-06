<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'id' => ['sometimes', 'integer'],
            'page' => ['sometimes', 'integer'],
            'image' => ['required', 'image'],
        ]);

        $file_name = Storage::disk('local')
            ->putFile($book->id, $request->file('image'));

        $page = updateOrCreate(
            [id => $request->input('id')],
            [
                ...$request->all()
                'file_name' => $file_name,
                $request->has('id') ? 'updated_by' : 'created_by' => Auth::id(),
            ]
        );

        return response()->json([
            'message' => 'Upload successed.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}
