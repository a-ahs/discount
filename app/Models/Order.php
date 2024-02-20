<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use niklasravnsborg\LaravelPdf\Pdf as LaravelPdfPdf;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'code',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateInvoice()
    {
        $pdf = FacadePdf::loadView('order.invoice', ['order' => $this]);
        return $pdf->save(storage_path('app\public\invoice\\') . $this->id . '.pdf');
    }

    public function paid()
    {
        return $this->payment->status;
    }

    public function downloadInvoice()
    {
        return Storage::disk('public')->download('invoice/' . $this->id . '.pdf');
    }

    public function invoicePath()
    {
        return storage_path('app\public\invoice\\' . $this->id . '.pdf');
    }
}
