<?php

use Livewire\Attributes\Title;
use Livewire\Volt\Component;
use function Livewire\Volt\{rules, state};

new #[Title('ورود به سامانه')]
class extends Component
{
    public function with(): array
    {
        return [
            'description' => 'ورود به سامانه گزارش الکترونیک',
            'keywords' => 'ورود, سامانه گزارش, شبکه بهداشت',
        ];
    }

    public string $national_id = '';
    public string $password = '';
    public bool $remember = false;

    public function rules(): array
    {
        return [
            'national_id' => ['required', 'string', 'size:10'],
            'password' => ['required', 'string'],
        ];
    }

    public function login()
    {
        $this->validate();

        if (auth()->attempt(['national_id' => $this->national_id, 'password' => $this->password], $this->remember)) {
            return redirect()->intended('/dashboard');
        }

        $this->addError('national_id', 'کدملی یا رمزعبور اشتباه است.');
    }
}
?>

<x-card title="ورود">
    <form wire:submit="login" class="space-y-4">
        <x-input label="کدملی" wire:model="national_id" placeholder="1234567890" required />
        <x-input label="رمزعبور" type="password" wire:model="password" required />
        <x-checkbox label="مرا به خاطر بسپار" wire:model="remember" />
        <x-button label="ورود" type="submit" class="btn-primary" />
        @error('national_id') <span class="text-red-500">{{ $message }}</span> @enderror
    </form>
</x-card>