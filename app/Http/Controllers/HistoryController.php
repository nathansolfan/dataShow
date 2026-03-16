<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $history = SearchHistory::orderBy('created_at', 'desc')->get();
        return view('history', compact('history'));
    }

    public function destroy(string $id)
    {
        SearchHistory::findOrFail($id)->delete();
        return back()->with('success', 'Record Deleted');
    }
}
