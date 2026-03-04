<?php

namespace App;

enum IdeaStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'border-amber-500/40 bg-amber-500/15 text-amber-300',
            self::InProgress => 'border-sky-500/40 bg-sky-500/15 text-sky-300',
            self::Completed => 'border-emerald-500/40 bg-emerald-500/15 text-emerald-300',
        };
    }
}
