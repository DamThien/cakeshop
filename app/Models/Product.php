<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property Carbon $created_at,
 * @property Carbon $updated_at,
 */
class Product extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';  // đây là thuộc tính ghi đè để chỉ định tên bảng được kết nối với mô hình

    use HasFactory;
    protected $fillable = [  //$fillable: dung để xạc định các cột trong bảng
        'name',
        'price',
        'image',
        'created_at',
        'updated_at',
    ]; //Models có thể thêm mới cập nhật,xóa
}






