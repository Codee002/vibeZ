<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountExport implements FromCollection, WithHeadings
{
    protected $accounts; // Khai báo một thuộc tính để lưu trữ Collection dữ liệu sản phẩm

    public function __construct(Collection $accounts)
    {
        $this->accounts = $accounts; // Constructor nhận một Collection các sản phẩm khi class được khởi tạo
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->accounts->map(function ($account) {
            return [
                "KH" . $account['id'],
                $account['name'],
                $account['phone'],
                $account['email'],
                $account['count_all_order'],
                $account['order_price'],
                $account['rank'],
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã KH',
            'Tên khách hàng',
            'Số điện thoại',
            'Email',
            'Tổng đơn hàng',
            'Thanh toán',
            'Cấp',
        ];
    }
}
