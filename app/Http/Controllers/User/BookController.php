<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'title' => ['required_without:id', 'string', 'max: 255'],
            'author_id' => ['sometimes', 'integer', 'exists:authors,id'],
            'detail' => ['sometimes', 'string'],
        ]);

        // $requestにidがない場合はnullとなりCreateされる。
        $book = Book::updateOrCreate(
            ['id' => $request->input('id')],
            [
                ...$request->all(),
                'created_by' => Auth::id(),
            ],
        );

        return response()->json([
            'book' => $book
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
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
