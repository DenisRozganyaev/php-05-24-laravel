<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Contracts\InvoiceServiceContract;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, InvoiceServiceContract $invoiceService)
    {
        $this->authorize('view', $order);

        return $invoiceService->generate($order)->stream();
    }
}
