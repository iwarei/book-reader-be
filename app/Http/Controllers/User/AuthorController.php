<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::query()
            ->get();

        return response()->json([
            'authors' => $authors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['sometimes', 'integer'],
            'name' => ['required', 'string', 'max: 255'],
        ]);

        // $requestにidがない場合はnullとなりCreateされる。
        $author = Author::updateOrCreate(
            ['id' => $request->input('id')], 
            [
                'name' => $request->input('name'),
                $request->has('id') ? 'updated_by' : 'created_by' => Auth::id(),
            ],
        );

        return response()->json(
            ['author' => $author], 
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->fill(['deleted_by' => Auth::id()])->save();
        $author->delete();

        return response()->json([
            'message' => 'Delete successed.',
        ]);
    }
}
