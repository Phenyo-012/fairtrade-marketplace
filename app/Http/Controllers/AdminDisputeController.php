<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use Illuminate\Http\Request;

class AdminDisputeController extends Controller
{

    public function index()
    {
        // FETCH ALL DISPUTES WITH RELATED ORDER AND USER DATA
        $disputes = Dispute::with('order','openedBy')
            ->latest()
            ->get();

        return view('admin.disputes.index', compact('disputes'));
    }

    // SHOW DISPUTE DETAILS
    public function show(Dispute $dispute)
    {
        return view('admin.disputes.show', compact('dispute'));
    }

    // RESOLVE DISPUTE
    public function resolve(Request $request, Dispute $dispute)
    {
        // VALIDATE INPUT
        $request->validate([
            'resolution_notes' => 'required'
        ]);

        // UPDATE DISPUTE STATUS AND NOTES
        $dispute->update([
            'status' => $request->status,
            'resolution_notes' => $request->resolution_notes,
            'resolved_by' => auth()->id()
        ]);

        return redirect()->route('admin.disputes')
            ->with('success','Dispute resolved successfully.');
    }
}