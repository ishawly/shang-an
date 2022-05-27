<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    private $tableName    = 'users';
    private $colAvatarUrl = 'avatar_url';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn($this->tableName, $this->colAvatarUrl)) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->string('avatar_url', 500)->nullable(false)->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, $this->colAvatarUrl)) {
            Schema::dropColumn($this->tableName, [$this->colAvatarUrl]);
        }
    }
};
