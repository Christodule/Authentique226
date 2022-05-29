<?php

namespace App\Contract\Admin;

interface SupplierInterface
{
    public function all();

    public function show($supplier);

    public function store(array $parms);

    public function destroy($supplier);

}
