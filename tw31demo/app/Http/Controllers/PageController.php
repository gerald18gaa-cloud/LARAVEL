<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        $data = [
            'course' => 'Web Systems Technologies!',
            'module' => 'Laravel Foundation.'
        ];

        return view('about', $data);
    }

    public function task($id)
    {
        $data = [
            'id' => $id,
            'title' => 'Buy groceries',
        ];

        return view('task', $data);
    }
}