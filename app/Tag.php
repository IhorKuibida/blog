<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{
    use Sluggable;
    protected $fillable = ['title'];

    public function posts(){
        return $this->belongsTo(
            Post::class,
            'post_tags',
            'tag_id',
            'post_id'
        );
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
        $Tag = new static;
        $Tag->fill($fields);
        $Tag->save();

        return  $Tag;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
}
