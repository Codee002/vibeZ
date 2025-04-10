<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatisticalExport implements FromCollection, WithHeadings
{
    protected $products; // Khai báo một thuộc tính để lưu trữ Collection dữ liệu sản phẩm

    public function __construct(Collection $products)
    {
        $this->products = $products; // Constructor nhận một Collection các sản phẩm khi class được khởi tạo
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                "SP" . $product->product_id,
                $product->product_name,
                $product->product_unit,
                $product->purchase_price,
                $product->sale_price,
                $product->quantity_receipt,
                $product->quantity_order,
                $product->quantity_ship,
                $product->quantity_warehouse,
                $product['purchase_price'] * $product['quantity_receipt'],
                $product['sale_price'] * $product['quantity_order'],
                $product['sale_price'] * $product['quantity_order'] -  $product['purchase_price'] * $product['quantity_receipt'],

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã SP',
            'Tên sản phẩm',
            'Đơn vị tính',
            'Giá nhập',
            'Giá bán',
            'SL nhập',
            'SL bán',
            'SL giao',
            'SL tồn',
            'Tổng giá nhập',
            'Tổng giá bán',
            'Doanh thu',
        ];
    }
}
