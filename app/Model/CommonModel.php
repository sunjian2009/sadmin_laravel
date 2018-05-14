<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommonModel extends Model
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public $timestamps = true;
    protected $primaryKey = 'id';
    //允许批量复制
    protected $guarded = [];
    //获取主键,laravel默认为自增列id
    public function getPk()
    {
        if ($this->primaryKey) {
            return $this->primaryKey;
        }
        return 'id';
    }

    /*
     * 实例化模型
     */
    public static function insModel($model)
    {
        $modelClass = '\App\Model\\' . $model;
        if (!class_exists($modelClass)) {
            ModelNotFoundException::class;
        }
        return $model = new $modelClass();
    }

    /*
     * 判断模型是否存在
     */
    public static function modelExists($model)
    {
        if (class_exists( '\App\Model\\' . $model)) {
            return true;
        }
    }

    //解析查询条件  和with连用有冲突，暂时还未解决
    public function parseWhereArray($map = [])
    {
        $model = $this;
        foreach ($map as $key => $value) {
            if (is_array($value)) {
                $model = $model->where($key, $value['ex'], $value['value']);
            } else {
                $model = $model->where($key, $value);
            }
        }
        return $model;
    }
}
