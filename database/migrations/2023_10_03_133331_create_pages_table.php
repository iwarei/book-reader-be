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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->comment('書籍ID')
                ->constrained();

            $table->string('file_name')
                ->comment('ファイル名');

            $table->integer('page')
                ->nullable()
                ->comment('頁');

            $table->timestamp('created_at')
                ->useCurrent()
                ->comment('登録日時');

            $table->integer('created_by')
                ->comment('登録者');

            $table->timestamp('updated_at')
                ->nullable()
                ->useCurrentOnUpdate()
                ->comment('更新日時');

            $table->integer('updated_by')
                ->nullable()
                ->comment('更新者');

            $table->SoftDeletes()
                ->comment('削除フラグ');


            $table->integer('deleted_by')
                ->nullable()
                ->comment('削除者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
