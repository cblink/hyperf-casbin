<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCasbinRuleTable extends Migration
{
    private $tableName = 'casbin_rule';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ptype', 10)->nullable();
            $table->string('v0', 50)->nullable();
            $table->string('v1', 50)->nullable();
            $table->string('v2', 50)->nullable();
            $table->string('v3', 50)->nullable();
            $table->string('v4', 50)->nullable();
            $table->string('v5', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            Schema::dropIfExists($this->tableName);
        });
    }
}
