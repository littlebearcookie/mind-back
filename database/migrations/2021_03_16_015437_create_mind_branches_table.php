<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMindBranchesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mind_branches', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('mind'); # Mind ID
			$table->bigInteger('parent'); # Parent ID
			$table->integer('level');
			$table->string('text');
			$table->string('background', 7)->default("#5990B2");
			$table->string('color', 7)->default("#FFFFFF");
			$table->char('weight')->default("F");
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('mind_branches');
	}
}
