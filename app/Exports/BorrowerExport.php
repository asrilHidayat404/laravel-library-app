<?php

namespace App\Exports;

use App\Models\BorrowedBook;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowerExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Ambil semua data peminjaman beserta relasinya.
     */
    public function collection()
    {
        return BorrowedBook::with(['book', 'member.user'])->get();
    }

    /**
     * Tentukan kolom yang akan ditampilkan di Excel.
     */
    public function map($borrowed): array
    {
        return [
            $borrowed->id_borrowed_book,
            $borrowed->book->title ?? '-',
            $borrowed->member->user->username ?? '-',
            $borrowed->borrowed_date ? $borrowed->borrowed_date->format('d-m-Y') : '-',
            $borrowed->due_date ? $borrowed->due_date->format('d-m-Y') : '-',
            $borrowed->returned_date ? $borrowed->returned_date->format('d-m-Y') : '-',
            ucfirst($borrowed->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan'),
        ];
    }

    /**
     * Header kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Judul Buku',
            'Nama Anggota',
            'Tanggal Pinjam',
            'Tanggal Jatuh Tempo',
            'Tanggal Kembali',
            'Status',
        ];
    }
}
