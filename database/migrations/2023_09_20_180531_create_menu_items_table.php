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
		Schema::create('menu_items', function (Blueprint $table) {
			$table->id();
			$table->foreignId('menu_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
			$table->string('name');
			$table->integer('type')->nullable();
			$table->string('source')->nullable();
			$table->integer('open_type')->nullable();
			$table->nestedSet();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('menu_items');
	}
};
