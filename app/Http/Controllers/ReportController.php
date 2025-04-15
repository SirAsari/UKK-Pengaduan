<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy("created_at", "asc")->paginate(10);

        return view("Reports.index", compact("reports"));
    }

    public function create()
    {
        return view("Reports.create");
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
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $report->image = $filename;
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
}
