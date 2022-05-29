<?php

namespace App\Http\Controllers\API\Admin;

use App\Contract\Admin\SaleQuotationInterface;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\SaleQuotationRequest;
use App\Models\Admin\SaleQuotation;
use App\Repository\Admin\SaleQuotationRepository;
use App\Services\Admin\SaleQuotationService;

class SaleQuotationController extends Controller
{
    private $SaleQuotationRepository;

    public function __construct(SaleQuotationInterface $SaleQuotationRepository)
    {
        $this->SaleQuotationRepository = $SaleQuotationRepository;
    }

    public function index()
    {
        return $this->SaleQuotationRepository->all();
    }

    public function show(SaleQuotation $SaleQuotation)
    {
        return $this->SaleQuotationRepository->show($SaleQuotation);
    }

    public function store(SaleQuotationRequest $request)
    {
        $parms = $request->all();
        $validated = new SaleQuotationService;
        $validated = $validated->SaleQuotationDetailValidate($request);
        if ($validated != '1') {
            return $validated;
        }
        return $this->SaleQuotationRepository->store($parms);
    }

    public function destroy($id)
    {
        return $this->SaleQuotationRepository->destroy($id);
    }

}
