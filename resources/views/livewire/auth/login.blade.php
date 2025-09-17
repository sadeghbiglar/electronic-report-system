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
            'description' => 'ورود به سامانه گزارش الکترونیک شبکه بهداشت و درمان',
            'keywords' => 'ورود, سامانه گزارش, شبکه بهداشت, الکترونیک',
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

<section class="min-h-screen flex items-center justify-center bg-base-200">
    <x-card title="ورود به سامانه" class="w-full max-w-md shadow-lg">
        <form wire:submit="login" class="space-y-6 p-6">
            <div>
                <x-input 
                    label="کدملی" 
                    wire:model="national_id" 
                    placeholder="1234567890" 
                    required 
                    class="w-full input-bordered" 
                />
                @error('national_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-input 
                    label="رمزعبور" 
                    type="password" 
                    wire:model="password" 
                    required 
                    class="w-full input-bordered" 
                />
            </div>
            <div>
                <x-checkbox 
                    label="مرا به خاطر بسپار" 
                    wire:model="remember" 
                    class="checkbox-primary" 
                />
            </div>
            <div class="flex justify-center">
                <x-button 
                    label="ورود" 
                    type="submit" 
                    class="btn-primary w-full sm:w-auto px-8" 
                />
            </div>
        </form>
    </x-card>
</section>