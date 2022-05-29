<?php

namespace App\Repository\Admin;

use App\Contract\Admin\SupplierInterface;
use App\Http\Resources\Admin\Supplier as SupplierResource;
use App\Models\Admin\Supplier;
use App\Services\Admin\AccountService;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;

class SupplierRepository implements SupplierInterface
{
    use ApiResponser;
    public function all()
    {
        try {
            $Supplier = new Supplier;

            if (isset($_GET['getAllData']) && $_GET['getAllData'] == '1') {
                return $this->successResponse(SupplierResource::collection($Supplier->get()), 'Data Get Successfully!');
            }

            if (isset($_GET['getCountry']) && $_GET['getCountry'] == '1') {
                $Supplier = $Supplier->with('country');
            }
            if (isset($_GET['getState']) && $_GET['getState'] == '1') {
                $Supplier = $Supplier->with('state');
            }
            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }

            $sortBy = ['id','first_name','last_name'];
            $sortType = ['ASC','DESC','asc','desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'],$sortBy) && in_array($_GET['sortType'],$sortType)) {
                $Supplier = $Supplier->orderBy($_GET['sortBy'],$_GET['sortType']);
            }

            if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
                $Supplier = $Supplier->searchParameter($_GET['searchParameter']);
            }
            
            return $this->successResponse(SupplierResource::collection($Supplier->paginate($numOfResult)) , 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($Supplier)
    {
        try {
            $Supplier = Supplier::SupplierId($Supplier->id);
            if (isset($_GET['getCountry']) && $_GET['getCountry'] == '1') {
                $Supplier = $Supplier->with('country');
            }
            if (isset($_GET['getState']) && $_GET['getState'] == '1') {
                $Supplier = $Supplier->with('state');
            }
            
            return $this->successResponse(new SupplierResource($Supplier->firstOrFail()) , 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        try {
            $sql = new Supplier;
            $sql = $sql->create($parms);
            $accounts = new AccountService;
            $accounts->createAccount('VENDOR', $parms['first_name']." ".$parms['last_name'], $sql->id,'supplier');
        } catch (Exception $e) {
            return $this->errorResponse();
        }

        if ($sql) {
            return $this->successResponse(new SupplierResource($sql), 'Supplier Save Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function update(array $parms, $Supplier)
    {
        try {
            $Supplier->update($parms);

        } catch (Exception $e) {
            return $this->errorResponse();
        }

        if ($Supplier) {
            return $this->successResponse(new SupplierResource($Supplier), 'Supplier Update Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function destroy($Supplier)
    {
        try {
            $sql = Supplier::findOrFail($Supplier);
            $sql->delete();

        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($sql) {
            return $this->successResponse('', 'Supplier Delete Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

}
