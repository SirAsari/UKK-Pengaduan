<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
