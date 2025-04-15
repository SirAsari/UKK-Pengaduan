<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->json('voted_by')->nullable()->after('voting'); // Store user IDs as JSON
        });
    }

    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('voted_by');
        });
    }
};
