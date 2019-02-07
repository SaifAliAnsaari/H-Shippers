<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplaintsAndSuggestions extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function complaints_suggestions(){
        return view('complaints_suggestions.complaints-list');
    }

    public function complaints_suggestions_client(){
        return view('complaints_suggestions.complaints-list-clients');
    }
}
