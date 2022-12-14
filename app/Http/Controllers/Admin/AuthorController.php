<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\Admin\AuthorRequest;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.authors.index');
        }

        $authors = Author::query();

        return Author::dataTable($authors);
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(AuthorRequest $request)
    {
        $input = $request->validated();
        if (!($input['order']??null)) {
            $input['order'] = Author::max('order') + 1;
        }
        $author = Author::create($input);
        $author->saveTranslations($input);

        return $this->jsonSuccess('Author created successfully', [
            'redirect' => route('admin.authors.index')
        ]);
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $input = $request->validated();

        $author->update($input);

        return $this->jsonSuccess('Author updated successfully');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return $this->jsonSuccess('Author deleted successfully');
    }
}
