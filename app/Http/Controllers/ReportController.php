<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Exports\ReportsExport;
use App\Exports\SingleReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Comment;

class ReportController extends Controller
{
    // public function index()
    // {
    //     $reports = Report::orderBy("created_at", "asc")->paginate(10);

    //     return view("Reports.index", compact("reports"));
    // }

    public function index(Request $request)
    {
        $sort = $request->input('sort', 'created_at'); // Default sort by created_at
        $order = $request->input('order', 'asc'); // Default order is ascending

        $reports = Report::orderBy($sort, $order)->paginate(10);

        return view('Reports.index', compact('reports', 'sort', 'order'));
    }

    public function create()
    {
        return view("Reports.create");
    }

    public function userCreate()
    {
        return view("user-reports.create");
    }
    
    public function store(Request $request)
{
    $this->validate($request, [
        'description' => 'required',
        'type' => 'required',
        'province' => 'required',
        'regency' => 'required',
        'subdistrict' => 'required',
        'village' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
    ]);

    $report = new Report();
    $report->user_id = auth()->user()->id;
    $report->description = $request->description;
    $report->type = $request->type;
    $report->province = $request->province;
    $report->regency = $request->regency;
    $report->subdistrict = $request->subdistrict;
    $report->village = $request->village;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('reports', 'public'); // Save the file in the 'storage/app/public/reports' directory
        $report->image = $path; // Store the relative path in the database
    }

    $report->save();

    return redirect()->route('report.index')->with('success', 'Report created successfully.');
}

    public function show($id)
    {
        $report = Report::find($id);
        return view('Reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = Report::find($id);
        return view('Reports.edit', compact('report'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
            'type' => 'required',
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
        ]);
        $report = Report::find($id);
        $report->description = $request->description;
        $report->type = $request->type;
        $report->province = $request->province;
        $report->regency = $request->regency;
        $report->subdistrict = $request->subdistrict;
        $report->village = $request->village;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $report->image = $filename;
        }
        $report->save();
        return redirect()->route('report.index')->with('success', 'Report updated successfully.');
    }
    public function destroy($id)
    {
        $report = Report::find($id);
        $report->delete();

        return redirect()->route('report.index')->with('success', 'Report deleted successfully.');
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $reports = Report::where('description', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->orWhere('province', 'LIKE', "%{$search}%")
            ->orWhere('regency', 'LIKE', "%{$search}%")
            ->orWhere('subdistrict', 'LIKE', "%{$search}%")
            ->orWhere('village', 'LIKE', "%{$search}%")
            ->orderBy("created_at", "asc")
            ->paginate(10);

        return view('Reports.index', compact('reports', 'search'));
    }

    public function export()
    {
        return Excel::download(new ReportsExport, 'reports.xlsx');
    }

    public function exportSingle($id)
    {
        $report = Report::findOrFail($id);
        return Excel::download(new SingleReportExport($report), 'report_' . $report->id . '.xlsx');
    }

    public function userIndex()
    {
        $reports = Report::orderBy('created_at', 'desc')->paginate(9);
        return view('user-reports.index', compact('reports'));
    }

    public function userShow($id)
    {
        // $report = Report::find($id);
        // return view('Reports.show', compact('report'));
        $report = Report::find($id);
        $report->increment('viewers');
        return view('user-reports.show', compact('report'));
    }

    public function addComment(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    $report = Report::findOrFail($id);

    $report->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->input('comment'),
    ]);

    return redirect()->route('user.report.show', $id)->with('success', 'Comment added successfully.');
}

public function vote($id)
{
    $report = Report::findOrFail($id);

    // Decode the `voted_by` JSON column into an array
    $votedBy = $report->voted_by ? json_decode($report->voted_by, true) : [];

    // Check if the user has already voted
    if (in_array(auth()->id(), $votedBy)) {
        return redirect()->route('user.report.show', $id)->with('error', 'You have already voted for this report.');
    }

    $votedBy[] = auth()->id();

    $report->update([
        'voted_by' => json_encode($votedBy),
        'voting' => $report->voting + 1,
    ]);

    return redirect()->route('user.report.show', $id)->with('success', 'Thank you for voting!');
}

public function headStaffDashboard()
{
    $totalReports = Report::count();

    $respondedReports = Report::whereIn('statement', ['done', 'on_process'])->count();

    $unrespondedReports = $totalReports - $respondedReports;

    return view('Admin.landingpage', compact('totalReports', 'respondedReports', 'unrespondedReports'));
}

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'statement' => 'required|in:on_process,done,rejected',
    ]);

    $report = Report::findOrFail($id);

    $report->update([
        'statement' => $request->input('statement'),
    ]);

    return redirect()->route('report.index')->with('success', 'Report status updated successfully.');
}
}
