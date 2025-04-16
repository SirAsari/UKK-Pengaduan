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
    $sort = $request->input('sort', 'created_at');
    $order = $request->input('order', 'asc');
    $search = $request->input('search');
    $filterType = $request->input('type');
    $filterProvince = $request->input('province');

    $reports = Report::query();

    if ($search) {
        $reports->where(function ($query) use ($search) {
            $query->where('description', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('province', 'LIKE', "%{$search}%");
        });
    }

    if ($filterType) {
        $reports->where('type', $filterType);
    }

    if ($filterProvince) {
        $reports->where('province', $filterProvince);
    }

    $reports = $reports->orderBy($sort, $order)->paginate(10);

    $types = Report::select('type')->distinct()->pluck('type');
    $provinces = Report::select('province')->distinct()->pluck('province');

    return view('Reports.index', compact('reports', 'sort', 'order', 'types', 'provinces', 'filterType', 'filterProvince', 'search'));
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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        $path = $file->store('reports', 'public');
        $report->image = $path;
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

    public function userIndex(Request $request)
{
    $query = Report::query();

    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('description', 'like', '%' . $request->search . '%')
              ->orWhere('type', 'like', '%' . $request->search . '%')
              ->orWhere('province', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('province')) {
        $query->where('province', $request->province);
    }

    $reports = $query->orderBy('created_at', 'desc')->paginate(9);

    $types = Report::select('type')->distinct()->pluck('type');
    $provinces = Report::select('province')->distinct()->pluck('province');

    return view('user-reports.index', compact('reports', 'types', 'provinces'));
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

    $badWords = ['memek', 'kontol', 'anjing', 'bangsat'];
    $comment = strtolower($request->input('comment'));

    foreach ($badWords as $badWord) {
        if (str_contains($comment, $badWord)) {
            return redirect()->back()->with('badword_detected', true);
        }
    }

    $report = Report::findOrFail($id);

    $report->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->input('comment'),
    ]);

    return redirect()->route('user.report.show', $id)->with('success', 'Komentar berhasil ditambahkan.');
}

public function addCommentAdmin(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    $report = Report::findOrFail($id);

    $report->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->input('comment'),
    ]);

    return redirect()->route('report.show', $id)->with('success', 'Comment added successfully.');
}

public function vote($id)
{
    $report = Report::findOrFail($id);

    $votedBy = $report->voted_by ? json_decode($report->voted_by, true) : [];

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

    $provinceData = Report::selectRaw('province, COUNT(*) as total')
        ->groupBy('province')
        ->pluck('total', 'province');

    return view('Admin.chart', compact(
        'totalReports',
        'respondedReports',
        'unrespondedReports',
        'provinceData'
    ));
}


public function updateStatus(Request $request, $id)
{
    $report = Report::findOrFail($id);

    if ($report->statement === 'done') {
        return redirect()->route('report.index')->with('error', 'This report status cannot be changed because it is already marked as "Done".');
    }

    $request->validate([
        'statement' => 'required|in:on_process,done,rejected',
    ]);

    $report->update([
        'statement' => $request->input('statement'),
    ]);

    return redirect()->route('report.index')->with('success', 'Report status updated successfully.');
}

}
