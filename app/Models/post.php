<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class post extends Model
{
    use HasFactory ,SoftDeletes;
    protected function formatDate() : Attribute {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('l jS \\of F Y h:i:s A')
        )
    ;}

    protected function indexdate() : Attribute {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('Y-m-d')
        )
    ;}

    public function comments (): MorphMany{

        return $this->morphMany(Comment::class, 'commentable');
    }

}

