<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['event','organizer']);
            $table->string('name')->nullable();
            $table->string('url');
            $table->longText('keywords')->nullable();
            $table->enum('automation_type', ['recurring', 'non_recurring']);
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->string('recurring_start_week_day')->nullable();
            $table->string('recurring_end_week_day')->nullable();
            $table->time('recurring_start_time')->nullable();
            $table->time('recurring_end_time')->nullable();
            $table->enum('is_enabled', ['0','1'])->default('1');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
