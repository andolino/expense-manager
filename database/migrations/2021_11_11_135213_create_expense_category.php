<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_category', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->timestamps();
        });
        // Insert default data
        DB::table('expense_category')->insert(
            array(
                array(
                    'category' => 'foods',
                    'created_at' => date('Y-m-d H:i:s')
                ),
                array(
                    'category' => 'transportation',
                    'created_at' => date('Y-m-d H:i:s')
                ),
                array(
                    'category' => 'bills',
                    'created_at' => date('Y-m-d H:i:s')
                )
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_category');
    }
}
