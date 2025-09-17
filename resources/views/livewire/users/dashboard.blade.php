<?php

use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('داشبورد')]
class extends Component
{
    public function with(): array
    {
        return [
            'description' => 'داشبورد سامانه گزارش الکترونیک',
            'keywords' => 'داشبورد, گزارش, شبکه بهداشت',
        ];
    }
}
?>

<x-card title="خوش آمدید">
    <p>به سامانه گزارش الکترونیک خوش آمدید، {{ auth()->user()->name }}</p>
</x-card>