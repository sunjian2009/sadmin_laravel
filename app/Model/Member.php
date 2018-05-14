<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table='member';
    protected $timestamps=true;
    //protected $fillable=[];
    //protected $guarded=[];
    protected function getDateFormat()
    {
        return time();
    }
    protected function asDateTime($value)
    {
        return $value;
    }

    public  function getMember(){
        //$list=$this::all();
        $list=$this::find(1);
        return $list;
    }


}
