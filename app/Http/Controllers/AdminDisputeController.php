<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use Illuminate\Http\Request;

class AdminDisputeController extends Controller
{

    public function index()
    {
        $disputes = Dispute::with('order','openedBy')
            ->latest()
            ->get();

        return view('admin.disputes.index', compact('disputes'));
    }

    public function show(Dispute $dispute)
    {
        return view('admin.disputes.show', compact('dispute'));
    }

    public function resolve(Request $request, Dispute $dispute)
    {
        $request->validate([
            'resolution_notes' => 'required'
        ]);

        $dispute->update([
            'status' => $request->status,
            'resolution_notes' => $request->resolution_notes,
            'resolved_by' => auth()->id()
        ]);

        return redirect()->route('admin.disputes')
            ->with('success','Dispute resolved successfully.');
    }
}