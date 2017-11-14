<?php
namespace Bantenprov\VueBlog\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Define POst model.
 */
class Blog extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = "blog";
    protected $dates = ['deleted_at'];
    protected $fillable = [
      'title',
      'content',
      'excerpt',
      'slug',
      'user_id',
    ];

   protected $hidden = [
       'deleted_at'
   ];

    function __construct()
    {
        // var_dump($this->fillable);
    }

    /**
     * A Post belongs to a single User.
     *
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
