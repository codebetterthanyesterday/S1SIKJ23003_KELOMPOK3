<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $storeIds;
    protected $filter;

    public function __construct($storeIds, $filter = null)
    {
        $this->storeIds = $storeIds;
        $this->filter = $filter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Product::with(['store', 'category'])
            ->whereIn('id_store', $this->storeIds);

        if ($this->filter) {
            switch ($this->filter) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '<=', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
            }
        }

        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Product ID',
            'Product Name',
            'Category',
            'Description',
            'Price',
            'Stock',
            'Store',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id_product,
            $row->product_name,
            $row->category->category_name,
            $row->description,
            'Rp ' . number_format($row->price, 0, ',', '.'),
            $row->stock,
            $row->store->store_name,
            $row->created_at->format('d-m-Y H:i:s'),
            $row->updated_at->format('d-m-Y H:i:s')
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
