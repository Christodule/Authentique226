<?php

namespace App\Http\Controllers\API\Admin;

use App\Contract\Admin\SupplierInterface;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Admin\Supplier;
use App\Repository\Admin\SupplierRepository;

class SupplierController extends Controller
{
    private $SupplierRepository;

    public function __construct(SupplierInterface $SupplierRepository)
    {
        $this->SupplierRepository = $SupplierRepository;
    }

    public function index()
    {
        return $this->SupplierRepository->all();
    }

    public function show(Supplier $Supplier)
    {
        return $this->SupplierRepository->show($Supplier);
    }

    public function store(SupplierRequest $request)
    {
        $parms = $request->all();
        return $this->SupplierRepository->store($parms);
    }

    public function update(SupplierRequest $request, Supplier $Supplier)
    {
        $parms = $request->all();
        return $this->SupplierRepository->update($parms, $Supplier);
    }

    public function destroy($id)
    {
        return $this->SupplierRepository->destroy($id);
    }

}
