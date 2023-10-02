<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::query()
            ->get();

        return response()->json([
            'books' => $books,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['sometimes', 'integer'],
            'title' => ['required', 'string', 'max: 255'],
            'detail' => ['sometimes', 'string'],
        ]);

        // $requestにidがない場合はnullとなりCreateされる。
        $author = Author::updateOrCreate(
            ['id' => $request->input('id')], 
            [
                'name' => $request->input('name'),
                'created_by' => Auth::id(),
            ],
        );

        return response()->json(
            ['author' => $author]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
