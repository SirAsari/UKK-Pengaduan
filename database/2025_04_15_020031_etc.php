<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
    }

    /**
     * Reverse the migrations.
     */

     Authentication (Laravel Breeze)


composer require laravel/breeze --dev php artisan breeze:install
npm install && npm run dev php artisan migrate

Export to Excel


composer require maatwebsite/excel
php artisan make:export UsersExport --model=User

// app/Exports/UsersExport.php use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection; use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings { public function collection() {
return User::select('id', 'name', 'email')->get();
}
public function headings(): array { return ['ID', 'Name', 'Email'];
}
}

// Route
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel; Route::get('/export-users', function () {
return Excel::download(new UsersExport, 'users.xlsx');
});

Search + Sort System (Blade Table)

// Controller
public function index(Request $request) {
$query = User::query();
if ($request->has('search')) {
$query->where('name', 'like', '%'.$request->search.'%');
}
if ($request->has('sort')) {
$query->orderBy($request->sort, $request->get('direction', 'asc'));
}
$users = $query->paginate(10);
return view('users.index', compact('users'));
}

// Blade Table Example
<form method="GET">
<input type="text" name="search" value="{{ request('search') }}">
<button type="submit">Search</button>
</form>
<a href="?sort=name&direction=asc">Sort Name ASC</a>
<a href="?sort=name&direction=desc">Sort Name DESC</a>

Migrations + Relationships

// One-to-Many Example
$table->foreignId('user_id')->constrained()->onDelete('cascade');

// User.php
public function posts() { return $this->hasMany(Post::class); }

// Post.php
public function user() { return $this->belongsTo(User::class); }

// One-to-One Example
$table->foreignId('user_id')->constrained()->onDelete('cascade');

// User.php
public function profile() { return $this->hasOne(Profile::class); }

// Profile.php
public function user() { return $this->belongsTo(User::class); }

Pie Chart (Chart.js + DB)

// Controller
$data = DB::table('users')
->select('role', DB::raw('count(*) as total'))
->groupBy('role')
->get();

// Blade
<canvas id="myPieChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('myPieChart').getContext('2d'); const chart = new Chart(ctx, {
type: 'pie', data: {
labels: {!! json_encode($data->pluck('role')) !!}, datasets: [{
data: {!! json_encode($data->pluck('total')) !!}, backgroundColor: ['#f87171', '#60a5fa', '#34d399']
}]
}
});
</script>


Step 1: Migrations
1.1 Create Users Table
php
Salin kode
php artisan make:migration create_users_table --create=users

database/migrations/{timestamp}_create_users_table.php:
php
Salin kode
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('role', ['guest', 'staff', 'head_staff'])->default('guest');
        $table->timestamps();
    });
}

1.2 Create Reports Table
php
Salin kode
php artisan make:migration create_reports_table --create=reports

database/migrations/{timestamp}_create_reports_table.php:
php
Salin kode
public function up()
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->text('description');
        $table->string('type');
        $table->string('province');
        $table->string('regency');
        $table->string('subdistrict');
        $table->string('village');
        $table->integer('voting')->default(0);
        $table->integer('viewers')->default(0);
        $table->string('image')->nullable();
        $table->enum('statement', ['pending', 'on_process', 'done', 'rejected'])->default('pending');
        $table->timestamps();
    });
}

1.3 Create Staff Provinces Table
php
Salin kode
php artisan make:migration create_staff_provinces_table --create=staff_provinces

database/migrations/{timestamp}_create_staff_provinces_table.php:
php
Salin kode
public function up()
{
    Schema::create('staff_provinces', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('province');
        $table->timestamps();
    });
}

1.4 Create Comments Table
php
Salin kode
php artisan make:migration create_comments_table --create=comments

database/migrations/{timestamp}_create_comments_table.php:
php
Salin kode
public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
        $table->text('comment');
        $table->timestamps();
    });
}

1.5 Create Responses Table
php
Salin kode
php artisan make:migration create_responses_table --create=responses

database/migrations/{timestamp}_create_responses_table.php:
php
Salin kode
public function up()
{
    Schema::create('responses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
        $table->enum('response_status', ['on_process', 'done', 'reject'])->default('on_process');
        $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

1.6 Create Response Progress Table
php
Salin kode
php artisan make:migration create_response_progress_table --create=response_progress

database/migrations/{timestamp}_create_response_progress_table.php:
php
Salin kode
public function up()
{
    Schema::create('response_progress', function (Blueprint $table) {
        $table->id();
        $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
        $table->text('histories');
        $table->timestamps();
    });
}

Run all migrations:
bash
Salin kode
php artisan migrate

________________________________________
Step 2: Models
2.1 User Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'password', 'role'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function staffProvinces()
    {
        return $this->hasMany(StaffProvince::class);
    }
}

2.2 Report Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'description', 'type', 'province', 'regency', 'subdistrict', 'village', 'voting', 'viewers', 'image', 'statement'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}

2.3 Comment Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'comment'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}

2.4 Response Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'response_status', 'staff_id'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function progress()
    {
        return $this->hasMany(ResponseProgress::class);
    }
}

2.5 ResponseProgress Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseProgress extends Model
{
    use HasFactory;

    protected $fillable = ['response_id', 'histories'];

    public function response()
    {
        return $this->belongsTo(Response::class);
    }
}

2.6 StaffProvince Model
php
Salin kode
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProvince extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'province'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

________________________________________
Step 3: Controllers
You'll need multiple controllers for this:
●	AuthController (for login, register)

●	ReportController (handle reports CRUD)

●	CommentController (handle comments)

●	ResponseController (handle staff responses)

●	ExportController (for export to Excel)

Let me know if you need the full code for the controllers, or if you want me to continue with the next steps in building views/routes!
1. ReportController
This controller will handle CRUD operations for the reports (pengaduan).
php
Salin kode
namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Display a listing of the reports
    public function index(Request $request)
    {
        $reports = Report::paginate(10);
        return view('reports.index', compact('reports'));
    }

    // Show the form for creating a new report
    public function create()
    {
        return view('reports.create');
    }

    // Store a newly created report in storage
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'type' => 'required',
            'province' => 'required',
            // other validation rules
        ]);

        $report = new Report([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'type' => $request->type,
            'province' => $request->province,
            // other fields
        ]);

        $report->save();
        return redirect()->route('reports.index');
    }

    // Display the specified report
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    // Show the form for editing the specified report
    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    // Update the specified report in storage
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'description' => 'required',
            'type' => 'required',
            // other validation rules
        ]);

        $report->update($request->all());
        return redirect()->route('reports.index');
    }

    // Remove the specified report from storage
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index');
    }
}

________________________________________
2. CommentController
This controller will handle the comments functionality related to reports.
php
Salin kode
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Report;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store a newly created comment in storage
    public function store(Request $request, Report $report)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new Comment([
            'report_id' => $report->id,
            'comment' => $request->comment,
        ]);

        $comment->save();
        return back();
    }
}

________________________________________
3. ResponseController
This controller will handle the responses from staff to the reports.
php
Salin kode
namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Report;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    // Store a newly created response in storage
    public function store(Request $request, Report $report)
    {
        $request->validate([
            'response_status' => 'required|in:on_process,done,reject',
        ]);

        $response = new Response([
            'report_id' => $report->id,
            'response_status' => $request->response_status,
            'staff_id' => auth()->id(),
        ]);

        $response->save();
        return back();
    }

    // Update the specified response in storage
    public function update(Request $request, Response $response)
    {
        $request->validate([
            'response_status' => 'required|in:on_process,done,reject',
        ]);

        $response->update([
            'response_status' => $request->response_status,
        ]);
        return back();
    }
}

________________________________________
4. ExportController
This controller will handle exporting the data to Excel.
php
Salin kode
namespace App\Http\Controllers;

use App\Models\Report;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export reports to Excel
    public function export(Request $request)
    {
        $query = Report::query();

        // Filter by date if specified
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $reports = $query->get();
        return Excel::download(new ReportsExport($reports), 'reports.xlsx');
    }
}

________________________________________
5. ReportsExport (For Exporting to Excel)
You’ll also need an Export class to structure the Excel export.
php
Salin kode
namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    // Define the data you want to export
    public function collection()
    {
        return $this->reports;
    }

    // Define the headings for Excel
    public function headings(): array
    {
        return [
            'ID', 'User ID', 'Description', 'Type', 'Province', 'Regency', 'Subdistrict', 'Village', 'Voting', 'Viewers', 'Image', 'Statement', 'Created At', 'Updated At',
        ];
    }
}

________________________________________
Routes
Finally, here are some example routes for these controllers.
php
Salin kode
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ExportController;

Route::resource('reports', ReportController::class);

Route::post('reports/{report}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('reports/{report}/responses', [ResponseController::class, 'store'])->name('responses.store');
Route::put('responses/{response}', [ResponseController::class, 'update'])->name('responses.update');

Route::get('export/reports', [ExportController::class, 'export'])->name('export.reports');

________________________________________
Views
You’ll need views for creating, viewing, and editing reports along with other pages for displaying comments, responses, etc.
________________________________________
Let me know if you need help creating those views or anything else!
4o mini
Anda bilang:
i need help with those too
ChatGPT bilang:
Sure thing! I’ll guide you through creating the views for your Report, Comment, and Response management. Here’s a basic structure you can follow for each view.
1. Reports Views
1.1 Index (reports/index.blade.php)
This view will display all the reports with pagination.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reports</h1>
        <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Create Report</a>

        <!-- Search form -->
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search reports..." value="{{ request('search') }}">
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Province</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->description }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{ $report->province }}</td>
                        <td>{{ $report->statement }}</td>
                        <td>
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reports->links() }} <!-- Pagination links -->
    </div>
@endsection

1.2 Create Report (reports/create.blade.php)
This view will allow users to create a new report.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Report</h1>
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
            </div>

            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" name="province" id="province" class="form-control" value="{{ old('province') }}" required>
            </div>

            <!-- Other fields (regency, subdistrict, etc.) -->

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

1.3 Show Report (reports/show.blade.php)
This view will show the details of a specific report.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Report #{{ $report->id }}</h1>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Type:</strong> {{ $report->type }}</p>
        <p><strong>Province:</strong> {{ $report->province }}</p>
        <p><strong>Status:</strong> {{ $report->statement }}</p>

        <!-- Comments -->
        <h2>Comments</h2>
        <form action="{{ route('comments.store', $report->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="comment" class="form-control" placeholder="Add a comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>

        <ul class="list-group mt-3">
            @foreach($report->comments as $comment)
                <li class="list-group-item">
                    {{ $comment->comment }}
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

1.4 Edit Report (reports/edit.blade.php)
This view will allow users to edit an existing report.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Report</h1>
        <form action="{{ route('reports.update', $report->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $report->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ $report->type }}">
            </div>

            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" name="province" id="province" class="form-control" value="{{ $report->province }}">
            </div>

            <!-- Other fields -->

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

________________________________________
2. Comment Views
Comments are added from the report details page, so you don’t need a separate view for the comments themselves. However, you will need to show the list of comments and allow users to add new ones. This is done within show.blade.php as I mentioned earlier.
________________________________________
3. Response Views
3.1 Add Response (responses/add.blade.php)
This view will allow staff to add a response to a report.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Respond to Report #{{ $report->id }}</h1>
        <form action="{{ route('responses.store', $report->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="response_status">Response Status</label>
                <select name="response_status" id="response_status" class="form-control" required>
                    <option value="on_process">On Process</option>
                    <option value="done">Done</option>
                    <option value="reject">Reject</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Response</button>
        </form>
    </div>
@endsection

3.2 Edit Response (responses/edit.blade.php)
This view will allow staff to edit a response.
php
Salin kode
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Response for Report #{{ $response->report->id }}</h1>
        <form action="{{ route('responses.update', $response->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="response_status">Response Status</label>
                <select name="response_status" id="response_status" class="form-control">
                    <option value="on_process" @selected($response->response_status === 'on_process')>On Process</option>
                    <option value="done" @selected($response->response_status === 'done')>Done</option>
                    <option value="reject" @selected($response->response_status === 'reject')>Reject</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Response</button>
        </form>
    </div>
@endsection

________________________________________
4. Export Reports View
The export functionality will be triggered through a button or a link. You could place it in the reports index page like this:
php
Salin kode
<!-- Export Button -->
<form action="{{ route('export.reports') }}" method="GET" class="mb-3">
    <button type="submit" class="btn btn-success">Export to Excel</button>
</form>

how to restrict certain user roles into only accesing some routes?
ChatGPT bilang:
To restrict certain user roles from accessing specific routes in Laravel, you can use middleware. Laravel’s built-in auth middleware ensures that only authenticated users can access certain routes. You can then create custom middleware to check the user’s role and restrict access accordingly.
1. Create Custom Middleware for Roles
First, let’s create custom middleware that checks for user roles.
Run the following Artisan command to create a new middleware:
bash
Salin kode
php artisan make:middleware CheckRole

2. Define the Role Check in the Middleware
Open the newly created CheckRole.php middleware file located in app/Http/Middleware/CheckRole.php. Update the handle() method to check for the user’s role.
php
Salin kode
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Redirect if the user doesn't have the correct role
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}

Here, the handle() method checks if the authenticated user has the required role. If not, they are redirected.
3. Register the Middleware
Next, register your middleware in the app/Http/Kernel.php file so that you can use it in your routes.
In the Kernel.php file, under the $routeMiddleware array, add the following line:
php
Salin kode
'role' => \App\Http\Middleware\CheckRole::class,

This registers the middleware with a name (role) that we can use in our routes.
4. Apply the Middleware to Routes
Now, you can apply this middleware to your routes. You can restrict access to certain routes based on the user’s role by adding the middleware to the route or route group.
4.1 Restrict Routes to Specific Roles
Here’s how you would restrict a route to a particular role (e.g., admin):
php
Salin kode
Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->middleware('role:admin');  // Only users with the 'admin' role can access this route

4.2 Restrict Multiple Roles
If you want to restrict access to multiple roles (e.g., admin and staff), you can update the middleware to accept multiple roles.
Modify the middleware to check for multiple roles:
php
Salin kode
public function handle(Request $request, Closure $next, ...$roles)
{
    if (Auth::check() && in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }

    // Redirect if the user doesn't have the correct role
    return redirect('/')->with('error', 'You do not have access to this page.');
}

Now, in your routes, you can apply multiple roles like this:
php
Salin kode
Route::get('/reports-management', function () {
    return view('reports.index');
})->middleware('role:admin,staff');  // Only admin and staff can access

4.3 Restrict Routes for Guests
To restrict access to authenticated users, use the built-in auth middleware. For example:
php
Salin kode
Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');  // Only authenticated users can access this route

5. Restrict Access for Guest Role
If you want to restrict access for users who are not logged in, you can simply add the auth middleware:
php
Salin kode
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');  // Only logged-in users can access

If you want to allow only guests (users not logged in), you can use the guest middleware:
php
Salin kode
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest');  // Only guests (not logged-in users) can access

6. Example of Middleware on Route Groups
You can also apply the middleware to a group of routes:
php
Salin kode
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/reports', function () {
        return view('admin.reports');
    });
});

In this example, only authenticated users with the role of admin can access both routes.
7. Using Policies (Optional)
For more granular control over user permissions (especially for more complex role management), you can use policies in Laravel. Policies are ideal when you need more than just a role check, for instance, when you want to determine if a user can update their own report.
You can create a policy with:
bash
Salin kode
php artisan make:policy ReportPolicy

Then, define methods inside the policy to check if a user can perform specific actions.

ROUTER WITH ACCESS RESTRICTION
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\ExportController;

// Guest routes (public)
Route::middleware('guest')->group(function () {
    Route::get('/', [ReportController::class, 'index']); // Landing page
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::get('/reports', [ReportController::class, 'index']); // View all reports
});

// Masyarakat (Regular User) routes
Route::middleware(['auth', 'role:masyarakat'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']); // View all reports
    Route::get('/reports/create', [ReportController::class, 'create']); // Create a new report
    Route::post('/reports', [ReportController::class, 'store']); // Store new report
    Route::post('/comments/{report}', [CommentController::class, 'store']); // Add a comment to a report
    Route::post('/votes/{report}', [ReportController::class, 'vote']); // Submit a vote for a report
});

// Petugas Daerah (Staff) routes
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff-dashboard', function () {
        return view('staff.dashboard');
    });

    Route::get('/reports/{report}', [ReportController::class, 'show']); // View report details
    Route::post('/responses/{report}', [ResponseController::class, 'store']); // Create a response to a report
    Route::put('/responses/{response}', [ResponseController::class, 'update']); // Update response status
    Route::get('/export/reports', [ExportController::class, 'export']); // Export reports as Excel
});

// Head Staff (Head Petugas Daerah) routes
Route::middleware(['auth', 'role:head_staff'])->group(function () {
    Route::get('/head-staff-dashboard', function () {
        return view('head_staff.dashboard');
    });

    Route::get('/reports/{report}/details', [ReportController::class, 'show']); // View detailed report
    Route::post('/responses/{report}', [ResponseController::class, 'store']); // Respond to a report
    Route::put('/responses/{response}', [ResponseController::class, 'update']); // Update response status
    Route::get('/export/reports', [ExportController::class, 'export']); // Export reports as Excel
    Route::get('/reports/sort-by-votes', [ReportController::class, 'sortByVotes']); // Sort reports by votes
});


how to add pie Grafik yang menunjukan jumlah pengaduan dan tanggapan pada daerah terkait
2/2
ChatGPT bilang:
To add a pie chart (grafik pie) that shows the number of reports and responses for a specific area (e.g., province), we can leverage a JavaScript charting library like Chart.js. Laravel will handle the backend part of retrieving the data and passing it to the front-end where Chart.js will render the pie chart.
Here’s a step-by-step guide:
1. Install Chart.js
First, we need to include Chart.js in our project. You can either install it using npm or directly include it from a CDN in your Blade view.
Option 1: Using CDN
Add this to your Blade template (e.g., resources/views/layouts/app.blade.php) inside the <head> tag:
html
SalinEdit
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

Option 2: Using npm
If you're using Laravel Mix (Webpack), you can install it via npm:
bash
SalinEdit
npm install chart.js --save

Then, in your resources/js/app.js file, import Chart.js:
javascript
SalinEdit
import Chart from 'chart.js';

Afterward, run npm run dev to compile your assets.
2. Create the Route for Fetching Data
In your controller, you need to fetch the number of reports and responses for a specific province and pass it to the view.
Let’s assume you have the following table structure:
●	Reports table has province and id.

●	Responses table has report_id and response_status with values like on_process, done, and reject.

You can create a method in your controller to count the number of reports and responses for a specific province.
Example: ReportController.php
php
SalinEdit
use App\Models\Report;
use App\Models\Response;
use Illuminate\Http\Request;

public function showProvinceChart($province)
{
    // Count reports by province
    $reportCount = Report::where('province', $province)->count();

    // Count responses by province
    $responseCount = Response::whereHas('report', function($query) use ($province) {
        $query->where('province', $province);
    })->count();

    // Prepare data for the chart
    return view('province-chart', compact('reportCount', 'responseCount', 'province'));
}

In this method:
●	We fetch the number of reports for the given province.

●	We fetch the number of responses related to reports from that province.

●	We pass the data to the view province-chart.

3. Create the Blade View with Chart.js
In your province-chart.blade.php file (or any other Blade view you prefer), you will display the pie chart. Here's an example:
php
SalinEdit
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pengaduan dan Tanggapan di Provinsi: {{ $province }}</h1>

        <!-- Canvas for the chart -->
        <canvas id="provinceChart" width="400" height="400"></canvas>

        <script>
            // Data for the pie chart
            var ctx = document.getElementById('provinceChart').getContext('2d');
            var provinceChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pengaduan', 'Tanggapan'],
                    datasets: [{
                        label: 'Jumlah Pengaduan dan Tanggapan',
                        data: [{{ $reportCount }}, {{ $responseCount }}],
                        backgroundColor: ['#ff6666', '#66b3ff'],
                        borderColor: ['#ffffff', '#ffffff'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
@endsection

4. Add the Route
In your web.php (routes file), add a route for this view. It should accept the province name as a parameter.
php
SalinEdit
Route::get('/province-chart/{province}', [ReportController::class, 'showProvinceChart']);

This route will call the showProvinceChart method and pass the province as a parameter to the view.
5. Test the Pie Chart
Now, when you visit the route /province-chart/{province}, it will render a pie chart showing the number of reports and responses for that province.
For example, if you go to /province-chart/WestJava, it will show a pie chart displaying the number of reports and responses for the "WestJava" province.
________________________________________
6. Optional Enhancements
●	Dynamic Data: You can make the chart update dynamically based on a dropdown where users can select different provinces.

●	Status Breakdown: Instead of just showing the total number of reports and responses, you can break the responses down by status (e.g., on_process, done, reject).

●	Customize Colors: You can change the color scheme of the pie chart to match your branding.

________________________________________
Conclusion
With this setup, you can easily display a pie chart that shows the number of reports and responses for a given province. Laravel handles the backend data, and Chart.js takes care of rendering the chart on the frontend.
Let me know if you need help with any other part of the process!

i forgot one thing, on the report table, it has image field right? how do i make upload image functionality and actually store it in my mysql and load the image in the index page of reports?
ChatGPT bilang:
Great question! Let's walk through how to upload an image, store its filename in MySQL, and display the image on your reports index page in Laravel.
________________________________________
✅ Step-by-Step: Upload and Display Image for Reports
________________________________________
🛠️ 1. Update Migration for reports Table (if not yet)
Make sure your reports table has an image field (usually string/varchar):
php
SalinEdit
// database/migrations/xxxx_xx_xx_create_reports_table.php
$table->string('image')->nullable();

Then run the migration if you haven’t already:
bash
SalinEdit
php artisan migrate

________________________________________
🧾 2. Update Your Report Form (Blade View)
In your create.blade.php or edit.blade.php (the report submission form), add an image input:
blade
SalinEdit
<form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- other inputs like description, type, etc. -->

    <div class="mb-3">
        <label for="image">Upload Gambar</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Kirim</button>
</form>

enctype="multipart/form-data" is required for file uploads.
________________________________________
⚙️ 3. Handle File Upload in Controller
In your ReportController.php, modify the store() method to handle the image upload:
php
SalinEdit
use Illuminate\Support\Facades\Storage;

public function store(Request $request)
{
    $request->validate([
        'description' => 'required',
        // other validations...
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('reports', 'public'); // Stored in storage/app/public/reports
    }

    Report::create([
        'user_id' => auth()->id(),
        'description' => $request->description,
        // other fields...
        'image' => $imagePath,
    ]);

    return redirect()->route('reports.index')->with('success', 'Laporan berhasil dikirim!');
}

________________________________________
📂 4. Set Up Storage Symlink
If you haven’t already, run this command so Laravel can publicly access uploaded files:
bash
SalinEdit
php artisan storage:link

It creates a storage folder in public/ that links to storage/app/public.
________________________________________
🖼️ 5. Display Image in Report Index Page
In your index.blade.php where you list all reports:
blade
SalinEdit
@foreach ($reports as $report)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $report->description }}</h5>

            @if($report->image)
                <img src="{{ asset('storage/' . $report->image) }}" alt="Gambar Pengaduan" width="200">
            @else
                <p><em>Tidak ada gambar</em></p>
            @endif
        </div>
    </div>
@endforeach


};
