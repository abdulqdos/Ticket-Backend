<?php

namespace App\actions\EventActions\CustomerActions ;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

Class CreateCustomerAction
{
    public function __construct(
        public string $phone,
        public ?string $backupPhone = null,
        public string $firstName,
        public string $lastName,
        public ?string $email = null,
        public string $password
    ) {}

    public function execute(): Customer
    {
        return DB::transaction(function () {
            return Customer::create([
                'phone'        => $this->phone,
                'backup_phone' => $this->backupPhone,
                'first_name'   => $this->firstName,
                'last_name'    => $this->lastName,
                'email'        => $this->email,
                'password'     => bcrypt($this->password),
            ]);
        });
    }
}
