<?php

namespace App\actions\CustomerActions ;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

Class UpdateCustomerAction
{
    public function __construct(
        public Customer $customer,
        public string $phone,
        public ?string $backupPhone = null,
        public string $firstName,
        public string $lastName,
        public ?string $email = null,
    ) {}

    public function execute(): Customer
    {
        return DB::transaction(function () {
            $this->customer->update([
                'phone'        => $this->phone,
                'backup_phone' => $this->backupPhone,
                'first_name'   => $this->firstName,
                'last_name'    => $this->lastName,
                'email'        => $this->email,
            ]);

            $this->customer->save();
            return  $this->customer;
        });
    }
}
