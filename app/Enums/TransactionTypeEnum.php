<?php

namespace App\Enums;

enum TransactionTypeEnum:int
{
    const TRANSFER = 1;
    const BANK_SLIP = 2;
    const REFUND = 3;

    public function label(): string {
        return match($this) {
            self::TRANSFER => 1,
            self::BANK_SLIP => 2,
            self::REFUND => 3,
        };
    }

    // Tipos de transação disponíveis para estorno
    static function getAllowedForRefund() {
        return [self::TRANSFER, self::BANK_SLIP];

    }

}
