<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->date('folow_up_date')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('manager_status_id')->nullable();
            $table->foreign('manager_status_id')->references('id')->on('statuses')->constrained()->onDelete('cascade');
            $table->enum('closure_month', ["January","February","March","April","May","June","July","August","September","October","November","December"])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('folow_up_date');
            $table->dropColumn('status_id');
            $table->dropColumn('manager_status_id');
            $table->dropColumn('closure_month');
        });
    }
}
