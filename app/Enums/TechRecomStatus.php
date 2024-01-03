<?php

namespace App\Enums;

enum TechRecomStatus: int
{
    case PINDING = 1;
    case APPROVED = 2;
    case CANCELLED = 3;

    public function color(): string
    {
        return match ($this) {
            TechRecomStatus::PINDING => 'primary',
            TechRecomStatus::APPROVED => 'success',
            TechRecomStatus::CANCELLED => 'danger',
        };
    }
}
