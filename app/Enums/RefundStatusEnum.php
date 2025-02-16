<?php

namespace App\Enums;

enum RefundStatusEnum:int
{
    const PENDING = 1;
    const DENIED = 2;
    const REFUNDED = 3;
    const CANCELLED = 4;
}
