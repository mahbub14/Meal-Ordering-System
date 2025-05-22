<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmployeeIdFromDailyMealsTable extends Migration
{
    public function up()
    {
        Schema::table('daily_meals', function (Blueprint $table) {
            // প্রথমে foreign key constraint drop করতে হবে
            $table->dropForeign(['employee_id']);

            // তারপর employee_id কলাম drop করতে হবে
            $table->dropColumn('employee_id');
        });
    }

    public function down()
    {
        Schema::table('daily_meals', function (Blueprint $table) {
            // rollback এ foreign key সহ কলাম আবার যোগ করা হবে
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        });
    }
}
