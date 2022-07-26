<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_notes', function (Blueprint $table) {
            $table->id();
            $table->text('notes');
            $table->date('folow_up_date');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('manager_status_id');
            $table->foreign('manager_status_id')->references('id')->on('statuses')->constrained()->onDelete('cascade');
            $table->enum('closure_month', ["January","February","March","April","May","June","July","August","September","October","November","December"]);
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools')->constrained()->onDelete('cascade');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_notes');
    }
}
