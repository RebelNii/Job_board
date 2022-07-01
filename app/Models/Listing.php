<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['title','tags','company','website','email','location','description','logo',];

    
    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags', 'like', '%' . request('tag') . '%');
        };

        if($filters['search'] ?? false){
            $query->where('title', 'like', '%' . request('search') . '%')->
            orWhere('description', 'like', '%' . request('search') . '%')->
            orWhere('tags', 'like', '%' . request('search') . '%');
        };
    }

    //eloquent relation with user
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
