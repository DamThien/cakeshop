<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't1s';  // đây là thuộc tính ghi đè để chỉ định tên bảng được kết nối với mô hình

    use HasFactory;
    protected $fillable = [  //$fillable: dung để xạc định các cột trong bảng
        'name',
        'price',
        'image',
        'rating',
        'sold',
        'id',
    ]; //Models có thể thêm mới cập nhật,xóa
}
