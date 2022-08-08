<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('school_type_id');
            $table->foreign('school_type_id')->references('id')->on('school_types')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('school_level_id');
            $table->foreign('school_level_id')->references('id')->on('school_levels')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')->references('id')->on('areas')->constrained()->onDelete('cascade');
            $table->integer('population')->nullable();
            $table->enum('system', ['Yes', 'No'])->nullable();
            $table->enum('online_student_portal', ['Yes', 'No'])->nullable();
            $table->text('name_of_the_system')->nullable();
            $table->date('contract_till')->nullable();
            $table->unsignedBigInteger('sales_rep_id');
            $table->foreign('sales_rep_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('sales_manager_id')->nullable();
            $table->foreign('sales_manager_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('telemarketing_rep_id')->nullable();
            $table->foreign('telemarketing_rep_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('director_id')->nullable();
            $table->foreign('director_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('onboarding_rep_id')->nullable();
            $table->foreign('onboarding_rep_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('onboarding_manager_id')->nullable();
            $table->foreign('onboarding_manager_id')->references('id')->on('role_users')->constrained()->onDelete('cascade');
            $table->enum('school_tution', ['Free', 'Paid'])->nullable();
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
        Schema::dropIfExists('schools');
    }
}
