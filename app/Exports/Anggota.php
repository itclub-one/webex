<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\admin\Anggota as AnggotaModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Anggota implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        if (auth()->user()->eskul_id == 0 || auth()->user()->kode == 'dev_daysf') {
            $data = AnggotaModel::with('kelas')
                                ->with('jurusan')
                                ->with('eskul')
                                ->orderBy('eskul_id','asc')
                                ->orderBy('kelas_id','asc')
                                ->orderBy('jurusan_id','asc')
                                ->get();
        } else {
            $data = AnggotaModel::with('kelas')
                                ->with('jurusan')
                                ->with('eskul')
                                ->where('eskul_id', auth()->user()->eskul_id)
                                ->orderBy('kelas_id','asc')
                                ->orderBy('jurusan_id','asc')
                                ->get();
        }

        return $data;
    }

    public function headings(): array
    {
        // Define your custom headers here
        $headers = [
            'No',
            'Nama',
            'Email',
            'Telepon',
            'Nis',
            'Kelas',
            'Jurusan',
        ];

        // Check if the user's kode is 'dev_daysf'
        if (auth()->user()->kode == 'dev_daysf' || auth()->user()->eskul_id == 0) {
            // Include 'Ekstrakurikuler' header
            $headers[] = 'Ekstrakurikuler';
        }

        // Add more headers as needed

        return $headers;
    }


    public function map($row): array
    {
        $mappedColumns = [
            // Use the key of the loop to represent the 'No' column
            $this->getRowIndex(),
            $row->nama,
            $row->email,
            $row->telepon,
            $row->nis,
            $row->kelas->kode, // Assuming 'kelas' is a relationship and 'kelas' has a 'kelas' column
            $row->jurusan->nama, // Assuming 'jurusan' is a relationship and 'jurusan' has a 'nama' column
        ];

        // Check if the user's kode is 'dev_daysf'
        if (auth()->user()->kode == 'dev_daysf' || auth()->user()->eskul_id == 0) {
            // Include 'Ekstrakurikuler' column
            $mappedColumns[] = $row->eskul->nama; // Assuming 'eskul' is a relationship and 'eskul' has a 'nama' column
        }

        return $mappedColumns;
    }

    private $rowIndex = 0;

    public function getRowIndex()
    {
        return ++$this->rowIndex;
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the heading row
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'], // Specify the font color for headings
            ],
        ]);

        // Apply styles to the map rows (excluding the heading)
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A2:H{$lastRow}")->applyFromArray([
            'font' => [
                'color' => ['rgb' => '000000'], // Specify the font color for map rows
            ],
        ]);
    }
}
